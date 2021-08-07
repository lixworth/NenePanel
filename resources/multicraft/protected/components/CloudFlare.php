<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class CloudFlare
{
    public $error = false;

    public function getZone($domain)
    {
        $parts = explode('.', $domain);
        if (count($parts) >= 2)
            $domain = $parts[count($parts)-2].'.'.$parts[count($parts)-1];
        $zone = $this->cfApi('GET', '/zones', array('name'=>$domain));
        if (!@$zone['success'] || !isset($zone['result'][0]['id']))
            return $this->setError(Yii::t('mc', 'Failed to query domain information'));
        return ''.@$zone['result'][0]['id'];
    }

    public function getRecord($zone_id, $name, $type = false)
    {
        $opts = array('name'=>$name);
        if ($type)
            $opts['type'] = $type;
        $record = $this->cfApi('GET', '/zones/'.$zone_id.'/dns_records', $opts);
        if (!@$record['success'])
            return $this->setError(Yii::t('mc', 'Failed to query subdomain information'));
        return ''.@$record['result'][0]['id'];
    }

    public function deleteRecord($zone_id, $record_id)
    {
        if (!$record_id)
            return true;
        $record = $this->cfApi('DELETE', '/zones/'.$zone_id.'/dns_records/'.$record_id);
        if (!@$record['success'])
            return $this->setError(Yii::t('mc', 'Failed to delete DNS record'));
        return true;
    }

    public function updateRecord($zone_id, $record_id, $data)
    {
        if ($record_id)
            $record = $this->cfApi('PUT', '/zones/'.$zone_id.'/dns_records/'.$record_id, $data);
        else
            $record = $this->cfApi('POST', '/zones/'.$zone_id.'/dns_records', $data);
        if (!@$record['success'] || !isset($record['result']['id']))
            return $this->setError(Yii::t('mc', 'Failed to create DNS record'));
        return ''.@$record['result']['id'];
    }

    private function setError($error)
    {
        $this->error = $error;
        return false;
    }

    private function handleCFError($severity, $message, $file, $line)
    {
        throw new ErrorException($message, $severity, $severity, $file, $line);
    }

    private function cfApi($method, $url, $data = array())
    {
        Yii::log('Calling CloudFlare API: '.$method.' "'.$url.'" '.($data ? CJSON::encode($data) : ''), 'info');
        $context = stream_context_create(array(
            'http'=>array(
                'method'=>$method,
                'ignore_errors'=>true,
                'header'=>'Content-Type: application/json'."\r\n"
                    .'X-Auth-Email: '.Yii::app()->params['user_subdomains_cf_email']."\r\n"
                    .'X-Auth-Key: '.Yii::app()->params['user_subdomains_cf_key']."\r\n"
                    .'User-Agent: Mozilla/5.0 (Multicraft Panel) like FireFox/45.0'."\r\n",
                'content'=>$method != 'GET' ? CJSON::encode($data) : '',
            ),
        ));
        set_error_handler(array($this, 'handleCFError'));
        $error = '';
        $res = '';
        try {
            $res = file_get_contents('https://api.cloudflare.com/client/v4'.$url
                .($method == 'GET' ? '?'.http_build_query($data) : ''), 0, $context);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
        restore_error_handler();
        if (!$res)
            Yii::log('Failed to connect to CloudFlare API: '.$error.', Headers: '.@$http_response_header[0], 'error');
        $json = CJSON::decode($res);
        if (!@$json['success'])
            Yii::log('CloudFlare API call failed, received: "'.$res.'"', 'error');
        // Enable the following for debugging:
        //else Yii::log('CloudFlare API call returned: "'.$res.'"', 'info');
        return $json;
    }

}
