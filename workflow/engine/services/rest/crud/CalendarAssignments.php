<?php

class Services_Rest_CalendarAssignments
{
    /**
     * Implementation for 'GET' method for Rest API
     *
     * @param  mixed $objectUid Primary key
     *
     * @return array $result Returns array within multiple records or a single record depending if
     *                       a single selection was requested passing id(s) as param
     */
    protected function get($objectUid=null)
    {
        $result = array();
        try {
            if (func_num_args() == 0) {
                $criteria = new Criteria('workflow');

                $criteria->addSelectColumn(CalendarAssignmentsPeer::OBJECT_UID);
                $criteria->addSelectColumn(CalendarAssignmentsPeer::CALENDAR_UID);
                $criteria->addSelectColumn(CalendarAssignmentsPeer::OBJECT_TYPE);
                
                $dataset = AppEventPeer::doSelectRS($criteria);
                $dataset->setFetchmode(ResultSet::FETCHMODE_ASSOC);

                while ($dataset->next()) {
                    $result[] = $dataset->getRow();
                }
            } else {
                $record = CalendarAssignmentsPeer::retrieveByPK($objectUid);
                $result = $record->toArray(BasePeer::TYPE_FIELDNAME);
            }
        } catch (Exception $e) {
            throw new RestException(412, $e->getMessage());
        }
        
        return $result;
    }


}