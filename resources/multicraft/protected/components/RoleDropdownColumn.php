<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

/**
 * Displays a role selection dropdown and calls an ajax function on change
 */
class RoleDropdownColumn extends CGridColumn
{
    protected function renderDataCellContent($row, $data)
    {
        $role = $data->getServerRole(Yii::app()->params['view_server_id']);
        $options[''] = Yii::t('mc', 'Unassigned');
        for($i = 0; $i < count(User::$roles); $i++)
            $options[User::$roles[$i]] = User::getRoleLabels($i);
        array_pop($options); // Remove owner
        if ($role == 'owner')
        {
            echo Yii::t('mc', 'Owner');
            return;
        }
        if (Yii::app()->params['view_role'] == 'coowner')
        {
            if ($role == 'coowner')
            {
                echo $options['coowner'];
                return;
            }
            array_pop($options); // Remove coowner
        }
        if (Yii::app()->params['view_role'] == 'admin')
        {
            if (in_array($role, array('admin', 'coowner')))
            {
                echo $options[$role];
                return;
            }
            array_pop($options); // Remove coowner
            array_pop($options); // Remove admin
        }
        if (isset($options['none']))
            $options['none'] = Yii::t('mc', 'No Access');
        echo CHtml::dropDownList('role_'.$data->id, $role, $options,
                array('ajax'=>array('type'=>'POST', 'data'=>array('ajax'=>'role', 'user'=>$data->id,
                    Yii::app()->request->csrfTokenName=>Yii::app()->request->csrfToken,
                        'role'=>"js:$('#role_".$data->id."').val()"), 'success'=>'js:function(e) {if(e)alert(e);}')));
    }

    protected function renderFilterCellContent()
    {
        if ((Yii::app()->params['hide_userlist'] === true) && !Yii::app()->user->isStaff())
            return;
        echo CHtml::dropDownList('roles_only', @$_GET['roles_only'], array('', Yii::t('mc', 'Users with Roles only')));
    }
}
