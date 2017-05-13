<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

// SalesPlatform.ru begin #4301
require_once 'modules/Settings/Groups/models/Group2OfferVisibility.php';
require_once 'modules/Settings/Groups/models/Group2CountryVisibility.php';
// SalesPlatform.ru end

// SalesPlatform.ru begin #4435
require_once 'modules/Settings/Groups/models/Group2DeliveryServiceVisibility.php';
// SalesPlatform.ru end

// SalesPlatform.ru begin #4458
require_once 'modules/Settings/Groups/models/Group2LandLangVisibility.php';
// SalesPlatform.ru end


class SalesOrder_ListView_Model extends Inventory_ListView_Model {

    /**
     * Function to get the list view entries
     * @param Vtiger_Paging_Model $pagingModel
     * @return array <Array> - Associative array of record id mapped to Vtiger_Record_Model instance.
     * @throws Exception
     */
    public function getSideBarListViewEntries($pagingModel) {
        $db = PearDatabase::getInstance();

        $moduleName = $this->getModule()->get('name');
        $moduleModel = Vtiger_Module_Model::getInstance($moduleName);

        $queryGenerator = $this->get('query_generator');

        $searchParams = $this->get('search_params');
        
        $searchParams = $this->groupSearchUsers($searchParams);
       //echo '<pre>',print_r($searchParams),'</pre>';
        if(empty($searchParams)) {
            $searchParams = array();
        }
        $glue = "";
        if(count($queryGenerator->getWhereFields()) > 0 && (count($searchParams)) > 0) {
            $glue = QueryGenerator::$AND;
        }
        $queryGenerator->parseAdvFilterList($searchParams, $glue);

        $searchKey = $this->get('search_key');
        $searchValue = $this->get('search_value');
        $operator = $this->get('operator');
        if(!empty($searchKey)) {
            $queryGenerator->addUserSearchConditions(array('search_field' => $searchKey, 'search_text' => $searchValue, 'operator' => $operator));
        }


        $orderBy = $this->getForSql('orderby');
        $sortOrder = $this->getForSql('sortorder');

        //List view will be displayed on recently created/modified records
        if(empty($orderBy) && empty($sortOrder) && $moduleName != "Users"){
            $orderBy = 'modifiedtime';
            $sortOrder = 'DESC';
        }

        if(!empty($orderBy)){
            $columnFieldMapping = $moduleModel->getColumnFieldMapping();
            $orderByFieldName = $columnFieldMapping[$orderBy];
            $orderByFieldModel = $moduleModel->getField($orderByFieldName);
            if($orderByFieldModel && $orderByFieldModel->getFieldDataType() == Vtiger_Field_Model::REFERENCE_TYPE){
                //IF it is reference add it in the where fields so that from clause will be having join of the table
                $queryGenerator = $this->get('query_generator');
                $queryGenerator->addWhereField($orderByFieldName);
            }
        }
        $listQuery = $this->getQuery();

        $sourceModule = $this->get('src_module');
        if(!empty($sourceModule)) {
            if(method_exists($moduleModel, 'getQueryByModuleField')) {
                $overrideQuery = $moduleModel->getQueryByModuleField($sourceModule, $this->get('src_field'), $this->get('src_record'), $listQuery);
                if(!empty($overrideQuery)) {
                    $listQuery = $overrideQuery;
                }
            }
        }

        if(!empty($orderBy)) {
            if($orderByFieldModel && $orderByFieldModel->isReferenceField()){
                $referenceModules = $orderByFieldModel->getReferenceList();
                $referenceNameFieldOrderBy = array();
                foreach($referenceModules as $referenceModuleName) {
                    $referenceModuleModel = Vtiger_Module_Model::getInstance($referenceModuleName);
                    $referenceNameFields = $referenceModuleModel->getNameFields();

                    $columnList = array();
                    foreach($referenceNameFields as $nameField) {
                        $fieldModel = $referenceModuleModel->getField($nameField);
                        $columnList[] = $fieldModel->get('table').$orderByFieldModel->getName().'.'.$fieldModel->get('column');
                    }
                    if(count($columnList) > 1) {
                        $referenceNameFieldOrderBy[] = getSqlForNameInDisplayFormat(array('first_name'=>$columnList[0],'last_name'=>$columnList[1]),'Users', '').' '.$sortOrder;
                    } else {
                        $referenceNameFieldOrderBy[] = implode('', $columnList).' '.$sortOrder ;
                    }
                }
                $listQuery .= ' ORDER BY '. implode(',',$referenceNameFieldOrderBy);
            }
            else if (!empty($orderBy) && $orderBy === 'smownerid') {
                $fieldModel = Vtiger_Field_Model::getInstance('assigned_user_id', $moduleModel);
                if ($fieldModel->getFieldDataType() == 'owner') {
                    $orderBy = 'COALESCE(CONCAT(vtiger_users.first_name,vtiger_users.last_name),vtiger_groups.groupname)';
                }
                $listQuery .= ' ORDER BY '. $orderBy . ' ' .$sortOrder;
            }
            else{
                $listQuery .= ' ORDER BY '. $orderBy . ' ' .$sortOrder;
            }
        }

        $viewid = ListViewSession::getCurrentView($moduleName);
        if(empty($viewid)) {
            $viewid = $pagingModel->get('viewid');
        }
        $_SESSION['lvs'][$moduleName][$viewid]['start'] = $pagingModel->get('page');

        ListViewSession::setSessionQuery($moduleName, $listQuery, $viewid);

        $listResult = $db->pquery($listQuery, array());

        $rowCount = $db->num_rows($listResult);

        $statusCounter = array('Новый' => 0, 'Ожидает оплаты' => 0, 'В обработке' => 0,
            'Отправлять' => 0, 'Доставка согласована' => 0, 'Приостановлен' => 0,
            'Доставить позже' => 0, 'Отправлен' => 0, 'Товар в точке получения' => 0,
            'Товар получен' => 0, 'Требует доработки оператора' => 0,
            'Доставлять' => 0, 'Отказ от отправки' => 0, 'Отказ от получения' => 0, 'Посылка вернулась' => 0,
            'Дубль' => 0, 'Брак' => 0, 'Недозвон' => 0, 'Консультация' => 0, 'Не целевой' => 0, 'Отказ' => 0, 'Тест' => 0,
            'Деньги получены' => 0,'Фейк' => 0,'Фейк вернулся' => 0,'Деньги получены от потери' => 0);
        for($i = 0; $i < $rowCount; $i++) {
            switch($db->query_result($listResult, $i, 'sostatus')) {
                case 'Новый':
                    $statusCounter['Новый']++;
                    break;
                case 'Ожидает оплаты':
                    $statusCounter['Ожидает оплаты']++;
                    break;
                case 'В обработке':
                    $statusCounter['В обработке']++;
                    break;
                case 'Отправлять':
                    $statusCounter['Отправлять']++;
                    break;
                case 'Доставка согласована':
                    $statusCounter['Доставка согласована']++;
                    break;
                case 'Приостановлен':
                    $statusCounter['Приостановлен']++;
                    break;
                case 'Отправлен':
                    $statusCounter['Отправлен']++;
                    break;
                case 'Товар в точке получения':
                    $statusCounter['Товар в точке получения']++;
                    break;
                case 'Товар получен':
                    $statusCounter['Товар получен']++;
                    break;
                case 'Требует доработки оператора':
                    $statusCounter['Требует доработки оператора']++;
                    break;
                case 'Доставлять':
                    $statusCounter['Доставлять']++;
                    break;
                case 'Отказ от отправки':
                    $statusCounter['Отказ от отправки']++;
                    break;
                case 'Отказ от получения':
                    $statusCounter['Отказ от получения']++;
                    break;
                case 'Посылка вернулась':
                    $statusCounter['Посылка вернулась']++;
                    break;
                case 'Дубль':
                    $statusCounter['Дубль']++;
                    break;
                case 'Брак':
                    $statusCounter['Брак']++;
                    break;
                case 'Недозвон':
                    $statusCounter['Недозвон']++;
                    break;
                case 'Консультация':
                    $statusCounter['Консультация']++;
                    break;
                case 'Не целевой':
                    $statusCounter['Не целевой']++;
                    break;
                case 'Отказ':
                    $statusCounter['Отказ']++;
                    break;                
                case 'Тест':
                    $statusCounter['Тест']++;
                    break;                
                case 'Деньги получены':
                    $statusCounter['Деньги получены']++;
                    break;
                case 'Фейк':
                    $statusCounter['Фейк']++;
                    break;
                case 'Фейк вернулся':
                    $statusCounter['Фейк вернулся']++;
                    break;
                case 'Деньги получены от потери':
                    $statusCounter['Деньги получены от потери']++;
                    break;
            }
        }
        return $statusCounter;
    }
    // SalesPlatform.ru begin #4094
    /**
     * Function to get the list of Mass actions for the module
     * @param $linkParams
     * @return array <Array> - Associative array of Link type to List of  Vtiger_Link_Model instances for Mass Actions
     * @throws Exception
     */
    public function getListViewMassActions($linkParams) {
        $currentUserModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        $moduleModel = $this->getModule();

        $linkTypes = array('LISTVIEWMASSACTION');
        $links = Vtiger_Link_Model::getAllByType($moduleModel->getId(), $linkTypes, $linkParams);


        $massActionLinks = array();
        if($currentUserModel->hasModuleActionPermission($moduleModel->getId(), 'EditView')) {
            $massActionLinks[] = array(
                'linktype' => 'LISTVIEWMASSACTION',
                'linklabel' => 'LBL_EDIT',
                'linkurl' => 'javascript:Vtiger_List_Js.triggerMassEdit("index.php?module='.$moduleModel->get('name').'&view=MassActionAjax&mode=showMassEditForm");',
                'linkicon' => ''
            );
        }
        if($currentUserModel->hasModuleActionPermission($moduleModel->getId(), 'Delete')) {
            $massActionLinks[] = array(
                'linktype' => 'LISTVIEWMASSACTION',
                'linklabel' => 'LBL_DELETE',
                'linkurl' => 'javascript:Vtiger_List_Js.massDeleteRecords("index.php?module='.$moduleModel->get('name').'&action=MassDelete");',
                'linkicon' => ''
            );
        }

        $massActionLinks[] = array(
            'linktype' => 'LISTVIEWMASSACTION',
            'linklabel' => 'LBL_LOGISTICS',
            'linkurl' => 'javascript:Vtiger_List_Js.massLogistics()',
            'linkicon' => ''
        );

        $modCommentsModel = Vtiger_Module_Model::getInstance('ModComments');
        if($moduleModel->isCommentEnabled() && $modCommentsModel->isPermitted('EditView')) {
            $massActionLinks[] = array(
                'linktype' => 'LISTVIEWMASSACTION',
                'linklabel' => 'LBL_ADD_COMMENT',
                'linkurl' => 'index.php?module='.$moduleModel->get('name').'&view=MassActionAjax&mode=showAddCommentForm',
                'linkicon' => ''
            );
        }

        foreach($massActionLinks as $massActionLink) {
            $links['LISTVIEWMASSACTION'][] = Vtiger_Link_Model::getInstanceFromValues($massActionLink);
        }

        return $links;
    }
    // SalesPlatform.ru end

    
    
    public function groupSearchUsers($searchParams) {
        $db = PearDatabase::getInstance();
        if(!isset($searchParams[0]['columns'])) {
            return $searchParams;
        }
        foreach ($searchParams[0]['columns'] as $name => &$item) {
            if($item['columnname'] == 'vtiger_crmentity:smownerid:assigned_user_id:SalesOrder_Assigned_To:V') {
                
                $value = '';
                foreach (explode(',', $item['value']) as $key_group => $group) {
                    if(strripos($group, 'group')) {
                        $sql = "SELECT
                                        CONCAT(vtiger_users.first_name, ' ', vtiger_users.last_name) as name
                                FROM
                                        vtiger_groups
                                LEFT JOIN vtiger_users2group ON vtiger_groups.groupid = vtiger_users2group.groupid
                                LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_users2group.userid
                                WHERE
                                        vtiger_groups.groupname = '{$group}'";
                                        
                        $result = $db->pquery($sql, array());
                        $count = $db->num_rows($result);
                        
                        for ($j = 0; $j < $count; ++$j) {
                            $value .= $db->query_result($result, $j, 'name') . ',';
                        }
                        
                    } else {
                        $value .= $group . ',';
                    }
                }
                
                $value = $value . '0';
                $item['value'] = $value;
            }
            
            
            
        }
      
        return $searchParams;
    }
    
    // SalesPlatform.ru begin #4301
    /**
     * Function to get the list view entries
     * @param Vtiger_Paging_Model $pagingModel
     * @return array <Array> - Associative array of record id mapped to Vtiger_Record_Model instance.
     * @throws Exception
     */
    public function getListViewEntries($pagingModel) {
        $db = PearDatabase::getInstance();

        $moduleName = $this->getModule()->get('name');
        $moduleFocus = CRMEntity::getInstance($moduleName);
        $moduleModel = Vtiger_Module_Model::getInstance($moduleName);

        $queryGenerator = $this->get('query_generator');
        $listViewController = $this->get('listview_controller');

        $searchParams = $this->get('search_params');
        if(empty($searchParams)) {
            $searchParams = array();
        }

        $searchParams = $this->groupSearchUsers($searchParams);
        
        $glue = "";
        if(count($queryGenerator->getWhereFields()) > 0 && (count($searchParams)) > 0) {
            $glue = QueryGenerator::$AND;
        }
        $queryGenerator->parseAdvFilterList($searchParams, $glue);

        $searchKey = $this->get('search_key');
        $searchValue = $this->get('search_value');
        $operator = $this->get('operator');
        if(!empty($searchKey)) {
            $queryGenerator->addUserSearchConditions(array('search_field' => $searchKey, 'search_text' => $searchValue, 'operator' => $operator));
        }


        // Add extra conditions
        $this->addExtraConditions($queryGenerator);


        $orderBy = $this->getForSql('orderby');
        $sortOrder = $this->getForSql('sortorder');

        //List view will be displayed on recently created/modified records
        if(empty($orderBy) && empty($sortOrder) && $moduleName != "Users"){
            //$orderBy = 'modifiedtime';
            $orderBy = 'createdtime';
            $sortOrder = 'DESC';
        }

        if(!empty($orderBy)){
            $columnFieldMapping = $moduleModel->getColumnFieldMapping();
            $orderByFieldName = $columnFieldMapping[$orderBy];
            $orderByFieldModel = $moduleModel->getField($orderByFieldName);
            if($orderByFieldModel && $orderByFieldModel->getFieldDataType() == Vtiger_Field_Model::REFERENCE_TYPE){
                //IF it is reference add it in the where fields so that from clause will be having join of the table
                $queryGenerator = $this->get('query_generator');
                $queryGenerator->addWhereField($orderByFieldName);
                //$queryGenerator->whereFields[] = $orderByFieldName;
            }
        }
        $listQuery = $this->getQuery();

        $sourceModule = $this->get('src_module');
        if(!empty($sourceModule)) {
            if(method_exists($moduleModel, 'getQueryByModuleField')) {
                $overrideQuery = $moduleModel->getQueryByModuleField($sourceModule, $this->get('src_field'), $this->get('src_record'), $listQuery);
                if(!empty($overrideQuery)) {
                    $listQuery = $overrideQuery;
                }
            }
        }

        $startIndex = $pagingModel->getStartIndex();
        $pageLimit = $pagingModel->getPageLimit();

        if(!empty($orderBy)) {
            if($orderByFieldModel && $orderByFieldModel->isReferenceField()){
                $referenceModules = $orderByFieldModel->getReferenceList();
                $referenceNameFieldOrderBy = array();
                foreach($referenceModules as $referenceModuleName) {
                    $referenceModuleModel = Vtiger_Module_Model::getInstance($referenceModuleName);
                    $referenceNameFields = $referenceModuleModel->getNameFields();

                    $columnList = array();
                    foreach($referenceNameFields as $nameField) {
                        $fieldModel = $referenceModuleModel->getField($nameField);
                        $columnList[] = $fieldModel->get('table').$orderByFieldModel->getName().'.'.$fieldModel->get('column');
                    }
                    if(count($columnList) > 1) {
                        $referenceNameFieldOrderBy[] = getSqlForNameInDisplayFormat(array('first_name'=>$columnList[0],'last_name'=>$columnList[1]),'Users', '').' '.$sortOrder;
                    } else {
                        $referenceNameFieldOrderBy[] = implode('', $columnList).' '.$sortOrder ;
                    }
                }
                $listQuery .= ' ORDER BY '. implode(',',$referenceNameFieldOrderBy);
            }
            else if (!empty($orderBy) && $orderBy === 'smownerid') {
                $fieldModel = Vtiger_Field_Model::getInstance('assigned_user_id', $moduleModel);
                if ($fieldModel->getFieldDataType() == 'owner') {
                    $orderBy = 'COALESCE(CONCAT(vtiger_users.first_name,vtiger_users.last_name),vtiger_groups.groupname)';
                }
                $listQuery .= ' ORDER BY '. $orderBy . ' ' .$sortOrder;
            }
            else{
                $listQuery .= ' ORDER BY '. $orderBy . ' ' .$sortOrder;
            }
        }
        $viewId = ListViewSession::getCurrentView($moduleName);
        if(empty($viewId)) {
            $viewId = $pagingModel->get('viewid');
        }
        $_SESSION['lvs'][$moduleName][$viewId]['start'] = $pagingModel->get('page');

        ListViewSession::setSessionQuery($moduleName, $listQuery, $viewId);

        $listQuery .= " LIMIT $startIndex,".($pageLimit+1);

        $listResult = $db->pquery($listQuery, array());

        $listViewRecordModels = array();
        $listViewEntries =  $listViewController->getListViewRecords($moduleFocus,$moduleName, $listResult);

        $pagingModel->calculatePageRange($listViewEntries);

        if($db->num_rows($listResult) > $pageLimit){
            array_pop($listViewEntries);
            $pagingModel->set('nextPageExists', true);
        }else{
            $pagingModel->set('nextPageExists', false);
        }

        $index = 0;
        foreach($listViewEntries as $recordId => $record) {
            $rawData = $db->query_result_rowdata($listResult, $index++);
            $record['id'] = $recordId;
            $listViewRecordModels[$recordId] = $moduleModel->getRecordFromArray($record, $rawData);
        }
        return $listViewRecordModels;
    }

    /**
     * Function to get the list view entries
     * @return mixed|string <Array> - Associative array of record id mapped to Vtiger_Record_Model instance.
     * @throws Exception
     * @internal param Vtiger_Paging_Model $pagingModel
     */
    public function getListViewCount() {
        $db = PearDatabase::getInstance();

        $queryGenerator = $this->get('query_generator');


        $searchParams = $this->get('search_params');
        if(empty($searchParams)) {
            $searchParams = array();
        }

        $glue = "";
        if(count($queryGenerator->getWhereFields()) > 0 && (count($searchParams)) > 0) {
            $glue = QueryGenerator::$AND;
        }
        $queryGenerator->parseAdvFilterList($searchParams, $glue);

        $searchKey = $this->get('search_key');
        $searchValue = $this->get('search_value');
        $operator = $this->get('operator');
        if(!empty($searchKey)) {
            $queryGenerator->addUserSearchConditions(array('search_field' => $searchKey, 'search_text' => $searchValue, 'operator' => $operator));
        }


        // Add extra conditions
        $this->addExtraConditions($queryGenerator);


        $listQuery = $this->getQuery();

        $sourceModule = $this->get('src_module');
        if(!empty($sourceModule)) {
            $moduleModel = $this->getModule();
            if(method_exists($moduleModel, 'getQueryByModuleField')) {
                $overrideQuery = $moduleModel->getQueryByModuleField($sourceModule, $this->get('src_field'), $this->get('src_record'), $listQuery);
                if(!empty($overrideQuery)) {
                    $listQuery = $overrideQuery;
                }
            }
        }
        $position = stripos($listQuery, ' from ');
        if ($position) {
            $split = spliti(' from ', $listQuery);
            $splitCount = count($split);
            $listQuery = 'SELECT count(*) AS count ';
            for ($i=1; $i<$splitCount; $i++) {
                $listQuery = $listQuery. ' FROM ' .$split[$i];
            }
        }

        if($this->getModule()->get('name') == 'Calendar'){
            $listQuery .= ' AND activitytype <> "Emails"';
        }

        $listResult = $db->pquery($listQuery, array());
        return $db->query_result($listResult, 0, 'count');
    }

    private function addExtraConditions(QueryGenerator $queryGenerator) {
        $offerSearchString = $this->getOfferVisibilityString();
        if($offerSearchString) {
            $queryGenerator->addUserSearchConditions(array('search_field' => 'sp_offer', 'search_text' => $offerSearchString, 'operator' => ''));
        }

        $countrySearchString = $this->getCountryVisibilityString();
        if($countrySearchString) {
            $queryGenerator->addUserSearchConditions(array('search_field' => 'sp_country', 'search_text' => $countrySearchString, 'operator' => ''));
        }

        $deliveryServiceSearchString = $this->getDeliveryServiceVisibilityString();
        if($deliveryServiceSearchString) {
            $queryGenerator->addUserSearchConditions(array('search_field' => 'sp_delivery_service', 'search_text' => $deliveryServiceSearchString, 'operator' => 'e'));
        }

        $landLangSearchString = $this->getLandLangVisibilityString();
        if($landLangSearchString) {
            $queryGenerator->addUserSearchConditions(array('search_field' => 'language_landing', 'search_text' => $landLangSearchString, 'operator' => ''));
        }

    }

    private function getOfferVisibilityString() {
        global $current_user;
        $currentUserGroups = Users_Record_Model::getUserGroups($current_user->id);
        if($currentUserGroups) {

            $offers = array();
            foreach($currentUserGroups as $key => $groupId) {
                $offers[$key] = Settings_Group2OfferVisibility_Record_Model::getOffersByGroupId($groupId);
            }

            $res = array();
            foreach($offers as $key => $val) {
                $res = array_merge($res, $val);
            }

            if($res) {
                return implode(',', $res);
            } else {
                return '';
            }
        }
        return '';
    }

    private function getCountryVisibilityString() {
        global $current_user;
        $currentUserGroups = Users_Record_Model::getUserGroups($current_user->id);
        if($currentUserGroups) {

            $countries = array();
            foreach($currentUserGroups as $key => $groupId) {
                $countries[$key] = Settings_Group2CountryVisibility_Record_Model::getCountriesByGroupId($groupId);
            }

            $res = array();
            foreach($countries as $key => $val) {
                $res = array_merge($res, $val);
            }

            if($res && !in_array('ALL', $res)) {
                return implode(',', $res);
            } else {
                return '';
            }
        }
        return '';
    }

    private function getDeliveryServiceVisibilityString() {
        global $current_user;
        $currentUserGroups = Users_Record_Model::getUserGroups($current_user->id);
        if($currentUserGroups) {

            $deliveryService = array();
            foreach($currentUserGroups as $key => $groupId) {
                $deliveryService[$key] = Settings_Group2DeliveryServiceVisibility_Record_Model::getDeliveryServicesByGroupId($groupId);
            }

            $res = array();
            foreach($deliveryService as $key => $val) {
                $res = array_merge($res, $val);
            }

            if($res && !in_array('ALL', $res)) {
                return implode(',', $res);
            } else {
                return '';
            }
        }
        return '';
    }

    private function getLandLangVisibilityString() {
        global $current_user;
        $currentUserGroups = Users_Record_Model::getUserGroups($current_user->id);
        if($currentUserGroups) {

            $landLang = array();
            foreach($currentUserGroups as $key => $groupId) {
                $landLang[$key] = Settings_Group2LandLangVisibility_Record_Model::getLandLangsByGroupId($groupId);
            }

            $res = array();
            foreach($landLang as $key => $val) {
                $res = array_merge($res, $val);
            }

            if($res && !in_array('ALL', $res)) {
                return implode(',', $res);
            } else {
                return '';
            }
        }
        return '';
    }
    // SalesPlatform.ru end
}