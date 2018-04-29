<?php

class eSputnikApi {
    const GROUP_SUBSCRIBERS = 'Subscribers';
    const GROUP_MASTERS = 'Masters';

    protected $login;
    protected $password;

    protected $allGroups = array(self::GROUP_SUBSCRIBERS, self::GROUP_MASTERS);

    function __construct() {
    }

    function auth($login, $password) {
        $this->login = $login;
        $this->password = $password;
    }

    public function postContact($contact, $groups) {
        $url = 'https://esputnik.com/api/v1/contacts';

        $request_entity = new stdClass();
        $request_entity->contacts = array($contact);
        $request_entity->dedupeOn = 'email';
        $request_entity->contactFields = array('firstName', 'email', 'sms', 'address', 'town', 'region');
        $request_entity->customFieldsIDs = array('76993', '76998', '77003', '77004', );
        $request_entity->groupNamesExclude = array_merge([], array_diff($this->allGroups, (array) $groups));
        $request_entity->groupNames = (array) $groups;
        $request_entity->restoreDeleted = true;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_entity));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            echo 'Curl error: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE) . ' | ' . curl_error($ch) . ' | ' . $output;
            return false;
        }

        curl_close($ch);
        return true;
    }

    public function postEvent($event) {
        $url = 'https://esputnik.com/api/v1/event';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($event));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            echo 'Curl error: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE) . ' | ' . curl_error($ch) . ' | ' . $output;
            return false;
        }

        curl_close($ch);
        return true;
    }

//    public function addContact($json_value) {
//        $url = 'https://esputnik.com/api/v1/contact';
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_value));
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $output = curl_exec($ch);
//
//        if ($output === false) {
//            echo 'Curl error: ' . curl_error($ch);
//            return false;
//        }
//
//        curl_close($ch);
//        return json_decode($output, true);
//    }

//    public function searchContact($email) {
//        $url = 'https://esputnik.com/api/v1/contacts?email=' . urlencode($email);
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $output = curl_exec($ch);
//
//        if ($output === false) {
//            echo 'Curl error: ' . curl_error($ch);
//            return false;
//        }
//
//        curl_close($ch);
//        return json_decode($output, true);
//    }

//    public function deleteContact($id) {
//        $url = 'https://esputnik.com/api/v1/contact/' . $id;
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $output = curl_exec($ch);
//
//        if ($output === false) {
//            echo 'Curl error: ' . curl_error($ch);
//            return false;
//        }
//
//        curl_close($ch);
//        return true;
//    }

//    public function updateContact($id, $json_value) {
//        $url = 'https://esputnik.com/api/v1/contact/' . $id;
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_value));
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $output = curl_exec($ch);
//
//        if ($output === false) {
//            echo 'Curl error: ' . curl_error($ch);
//            return false;
//        }
//
//        curl_close($ch);
//        return json_decode($output, true);
//    }

//    public function getContact($id) {
//        $url = 'https://esputnik.com/api/v1/contact/' . $id;
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $output = curl_exec($ch);
//
//        if ($output === false) {
//            echo 'Curl error: ' . curl_error($ch);
//            return false;
//        }
//
//        curl_close($ch);
//        return json_decode($output, true);
//    }
}