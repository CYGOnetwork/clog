<?php

/**

 */
class BLOGS_CLASS_Credits
{
    private $actions = array();

    private $authActions = array();
    
    public function __construct()
    {
        $this->actions[] = array('pluginKey' => 'blogs', 'action' => 'add_blog', 'amount' => 0);
        $this->actions[] = array('pluginKey' => 'blogs', 'action' => 'add_comment', 'amount' => 0);

        $this->authActions['add'] = 'add_blog';
        $this->authActions['add_comment'] = 'add_comment';
    }
    
    public function bindCreditActionsCollect( BASE_CLASS_EventCollector $e )
    {
        foreach ( $this->actions as $action )
        {
            $e->add($action);
        }        
    }
    
    public function triggerCreditActionsAdd()
    {
        $e = new BASE_CLASS_EventCollector('usercredits.action_add');
        
        foreach ( $this->actions as $action )
        {
            $e->add($action);
        }

        OW::getEventManager()->trigger($e);
    }

    public function getActionKey( OW_Event $e )
    {
        $params = $e->getParams();
        $authAction = $params['actionName'];

        if ( $params['groupName'] != 'blogs' )
        {
            return;
        }

        if ( !empty($this->authActions[$authAction]) )
        {
            $e->setData($this->authActions[$authAction]);
        }
    }
}
