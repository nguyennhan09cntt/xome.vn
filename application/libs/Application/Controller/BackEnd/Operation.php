<?php
class Application_Controller_BackEnd_Operation extends Application_Controller_BackEnd
{
    public function init()
    {
        $this->adminInfo = Application_Session_Operation::getInstance()->load();
    }

    /**
     * Send ticket notification
     * @param int $ticketId
     * @param int $statusId
     */
    protected function sendTicketNotification($ticketId, $statusId)
    {
        if ($ticketId && $statusId) {
            $ticketInfo = Operation_Model_Ticket::getInstance()->getFullDetail($ticketId);
            if ($ticketInfo->{DbTable_Company_Trip::COL_COMPANY_TRIP_SEAT_BOOKING} == Application_Constant_Db_Company_Trip::SEAT_BOOKING) {
                $emailIdData = array(
                    Application_Constant_Db_Config_Ticket_Status::CONFIRMED_CUSTOMER => Application_Constant_Db_Site_Email::TICKET_INFO,
                    Application_Constant_Db_Config_Ticket_Status::IN_DELIVERED => Application_Constant_Db_Site_Email::IN_DELIVERY,
                    Application_Constant_Db_Config_Ticket_Status::CANCELLED_HAVING_TICKET => Application_Constant_Db_Site_Email::CANCELLATION,
                    Application_Constant_Db_Config_Ticket_Status::CANCELLED_NO_TICKET => Application_Constant_Db_Site_Email::CANCELLATION,
                );
            } else {
                $emailIdData = array(
                    Application_Constant_Db_Config_Ticket_Status::CONFIRMED_CUSTOMER => Application_Constant_Db_Site_Email::NON_BOOKING_TICKET_INFO,
                    Application_Constant_Db_Config_Ticket_Status::IN_DELIVERED => Application_Constant_Db_Site_Email::NON_BOOKING_IN_DELIVERY,
                    Application_Constant_Db_Config_Ticket_Status::CANCELLED_HAVING_TICKET => Application_Constant_Db_Site_Email::CANCELLATION,
                    Application_Constant_Db_Config_Ticket_Status::CANCELLED_NO_TICKET => Application_Constant_Db_Site_Email::CANCELLATION,
                );
            }

            $emailId = isset($emailIdData[$statusId]) ? $emailIdData[$statusId] : 0;

            if ($statusId == Application_Constant_Db_Config_Ticket_Status::CONFIRMED_CUSTOMER) {
                $response = Operation_Model_Ticket::getInstance()->proceedWaitingForPickup($ticketId);
                $response = intval($response);
                if (!$response) {
                    $emailId = Application_Constant_Db_Site_Email::TICKET_INFO_SELLING_TIME;
                }
            }

            if ($emailId) {
                $ticketIdData = is_array($ticketId) ? $ticketId : array($ticketId);
                foreach ($ticketIdData as $id) {
                    $this->sendNotification($emailId, $id);
                }
            }
        }
    }
}