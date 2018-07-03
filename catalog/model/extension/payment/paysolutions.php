<?php

class ModelExtensionPaymentPaysolutions extends Model
{

    /*  This function getMethod is calling payment method */
    public function getMethod($address, $total) {

        $this->load->language('extension/payment/paysolutions');
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");


        if ($this->config->get('paysolutions_total') > 0 && $this->config->get('paysolutions_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('cod_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            $method_data = array(
                'code' => 'paysolutions',
                'title' => $this->language->get('text_title'),
                'terms' => '',
                'sort_order' => $this->config->get('paysolutions_sort_order')
            );
        }

        return $method_data;
    }

    /*  This function addOrder Will save order data in tables    */
    public function addOrder($order_data, $user_id) {

        /* 1 to 1 relationship with order table (extends order info) */
        $this->db->query("INSERT INTO `" . DB_PREFIX . "paysolutions_order` SET
            `order_id`                      = '". (array_key_exists('order_id',$order_data) ? $this->db->escape($order_data['order_id']) : '' ) ."',
            `merchant_id`                   = '". (array_key_exists('merchant_id',$order_data) ? $this->db->escape($order_data['merchant_id']) : '' ) ."',
            `refno`                    = '". (array_key_exists('refno',$order_data) ? $this->db->escape($order_data['refno']) : '' ) ."',
            `customeremail`               = '". (array_key_exists('customeremail',$order_data) ? $this->db->escape($order_data['customeremail']) : '' ) ."',
            `status`                = '". (array_key_exists('status',$order_data) ? $this->db->escape($order_data['status']) : '' ) ."',
            `productdetail`         = '". (array_key_exists('productdetail',$order_data) ? $this->db->escape($order_data['productdetail']) : '' ) ."',
            `total`                        = '". (array_key_exists('total',$order_data) ? $this->db->escape($order_data['total']) : '' ) ."',            
            `currency`         = '00'");

        return $this->db->getLastId();
    }

    public function updateOrder($order_data, $user_id) {

        $this->db->query(" UPDATE `" . DB_PREFIX . "paysolutions_order` SET
            `order_id`                      = '". (array_key_exists('order_id',$order_data) ? $this->db->escape($order_data['order_id']) : '' ) ."',
            `merchant_id`                   = '". (array_key_exists('merchant_id',$order_data) ? $this->db->escape($order_data['merchant_id']) : '' ) ."',
            `refno`                    = '". (array_key_exists('refno',$order_data) ? $this->db->escape($order_data['refno']) : '' ) ."',
            `customeremail`               = '". (array_key_exists('customeremail',$order_data) ? $this->db->escape($order_data['customeremail']) : '' ) ."',
            `status`                = '". (array_key_exists('status',$order_data) ? $this->db->escape($order_data['status']) : '' ) ."',
            `productdetail`         = '". (array_key_exists('productdetail',$order_data) ? $this->db->escape($order_data['productdetail']) : '' ) ."',
            `total`                        = '". (array_key_exists('total',$order_data) ? $this->db->escape($order_data['total']) : '' ) ."',
            `currency`                      = '00'
             WHERE order_id = '" . $order_data['order_id'] . "'");
    }

    public function isOrderExists($order_id) {

        $result =  $this->db->query("SELECT * FROM " . DB_PREFIX . "paysolutions_order WHERE  order_id = ". $order_id);

        if($result->num_rows) {
            return true;
        }

        return false;
    }

    public function getCustomeOrderStatus($order_status_name) {

        $result = $this->db->query("SELECT order_status_id FROM " . DB_PREFIX . "order_status WHERE name = '" .$order_status_name ."'");

        return $result->row['order_status_id'];
    }

    public function getdata($order_id) {

        $qry = $this->db->query("SELECT * FROM " . DB_PREFIX . "paysolutions_order WHERE order_id = '" . $order_id ."'");

        return $qry;
    }

    public function getCurrencies() {
        return array(
            "CLF" => array(
                "Num" => "990",
                "exponent" => "4"
            ),
            "BHD" => array(
                "Num" => "048",
                "exponent" => "3"
            ),
            "IQD" => array(
                "Num" => "368",
                "exponent" => "3"
            ),
            "JOD" => array(
                "Num" => "400",
                "exponent" => "3"
            ),
            "KWD" => array(
                "Num" => "414",
                "exponent" => "3"
            ),
            "LYD" => array(
                "Num" => "434",
                "exponent" => "3"
            ),
            "OMR" => array(
                "Num" => "512",
                "exponent" => "3"
            ),
            "TND" => array(
                "Num" => "788",
                "exponent" => "3"
            ),
            "AED" => array(
                "Num" => "784",
                "exponent" => "2"
            ),
            "AFN" => array(
                "Num" => "971",
                "exponent" => "2"
            ),
            "ALL" => array(
                "Num" => "008",
                "exponent" => "2"
            ),
            "AMD" => array(
                "Num" => "051",
                "exponent" => "2"
            ),
            "ANG" => array(
                "Num" => "532",
                "exponent" => "2"
            ),
            "AOA" => array(
                "Num" => "973",
                "exponent" => "2"
            ),
            "ARS" => array(
                "Num" => "032",
                "exponent" => "2"
            ),
            "AUD" => array(
                "Num" => "036",
                "exponent" => "2"
            ),
            "AWG" => array(
                "Num" => "533",
                "exponent" => "2"
            ),
            "AZN" => array(
                "Num" => "944",
                "exponent" => "2"
            ),
            "BAM" => array(
                "Num" => "977",
                "exponent" => "2"
            ),
            "BBD" => array(
                "Num" => "052",
                "exponent" => "2"
            ),
            "BDT" => array(
                "Num" => "050",
                "exponent" => "2"
            ),
            "BGN" => array(
                "Num" => "975",
                "exponent" => "2"
            ),
            "BMD" => array(
                "Num" => "060",
                "exponent" => "2"
            ),
            "BND" => array(
                "Num" => "096",
                "exponent" => "2"
            ),
            "BOB" => array(
                "Num" => "068",
                "exponent" => "2"
            ),
            "BOV" => array(
                "Num" => "984",
                "exponent" => "2"
            ),
            "BRL" => array(
                "Num" => "986",
                "exponent" => "2"
            ),
            "BSD" => array(
                "Num" => "044",
                "exponent" => "2"
            ),
            "BTN" => array(
                "Num" => "064",
                "exponent" => "2"
            ),
            "BWP" => array(
                "Num" => "072",
                "exponent" => "2"
            ),
            "BYN" => array(
                "Num" => "933",
                "exponent" => "2"
            ),
            "BZD" => array(
                "Num" => "084",
                "exponent" => "2"
            ),
            "CAD" => array(
                "Num" => "124",
                "exponent" => "2"
            ),
            "CDF" => array(
                "Num" => "976",
                "exponent" => "2"
            ),
            "CHE" => array(
                "Num" => "947",
                "exponent" => "2"
            ),
            "CHF" => array(
                "Num" => "756",
                "exponent" => "2"
            ),
            "CHW" => array(
                "Num" => "948",
                "exponent" => "2"
            ),
            "CNY" => array(
                "Num" => "156",
                "exponent" => "2"
            ),
            "COP" => array(
                "Num" => "170",
                "exponent" => "2"
            ),
            "COU" => array(
                "Num" => "970",
                "exponent" => "2"
            ),
            "CRC" => array(
                "Num" => "188",
                "exponent" => "2"
            ),
            "CUC" => array(
                "Num" => "931",
                "exponent" => "2"
            ),
            "CUP" => array(
                "Num" => "192",
                "exponent" => "2"
            ),
            "CZK" => array(
                "Num" => "203",
                "exponent" => "2"
            ),
            "DKK" => array(
                "Num" => "208",
                "exponent" => "2"
            ),
            "DOP" => array(
                "Num" => "214",
                "exponent" => "2"
            ),
            "DZD" => array(
                "Num" => "012",
                "exponent" => "2"
            ),
            "EGP" => array(
                "Num" => "818",
                "exponent" => "2"
            ),
            "ERN" => array(
                "Num" => "232",
                "exponent" => "2"
            ),
            "ETB" => array(
                "Num" => "230",
                "exponent" => "2"
            ),
            "EUR" => array(
                "Num" => "978",
                "exponent" => "2"
            ),
            "FJD" => array(
                "Num" => "242",
                "exponent" => "2"
            ),
            "FKP" => array(
                "Num" => "238",
                "exponent" => "2"
            ),
            "GBP" => array(
                "Num" => "826",
                "exponent" => "2"
            ),
            "GEL" => array(
                "Num" => "981",
                "exponent" => "2"
            ),
            "GHS" => array(
                "Num" => "936",
                "exponent" => "2"
            ),
            "GIP" => array(
                "Num" => "292",
                "exponent" => "2"
            ),
            "GMD" => array(
                "Num" => "270",
                "exponent" => "2"
            ),
            "GTQ" => array(
                "Num" => "320",
                "exponent" => "2"
            ),
            "GYD" => array(
                "Num" => "328",
                "exponent" => "2"
            ),
            "HKD" => array(
                "Num" => "344",
                "exponent" => "2"
            ),
            "HNL" => array(
                "Num" => "340",
                "exponent" => "2"
            ),
            "HRK" => array(
                "Num" => "191",
                "exponent" => "2"
            ),
            "HTG" => array(
                "Num" => "332",
                "exponent" => "2"
            ),
            "HUF" => array(
                "Num" => "348",
                "exponent" => "2"
            ),
            "IDR" => array(
                "Num" => "360",
                "exponent" => "2"
            ),
            "ILS" => array(
                "Num" => "376",
                "exponent" => "2"
            ),
            "INR" => array(
                "Num" => "356",
                "exponent" => "2"
            ),
            "IRR" => array(
                "Num" => "364",
                "exponent" => "2"
            ),
            "JMD" => array(
                "Num" => "388",
                "exponent" => "2"
            ),
            "KES" => array(
                "Num" => "404",
                "exponent" => "2"
            ),
            "KGS" => array(
                "Num" => "417",
                "exponent" => "2"
            ),
            "KHR" => array(
                "Num" => "116",
                "exponent" => "2"
            ),
            "KPW" => array(
                "Num" => "408",
                "exponent" => "2"
            ),
            "KYD" => array(
                "Num" => "136",
                "exponent" => "2"
            ),
            "KZT" => array(
                "Num" => "398",
                "exponent" => "2"
            ),
            "LAK" => array(
                "Num" => "418",
                "exponent" => "2"
            ),
            "LBP" => array(
                "Num" => "422",
                "exponent" => "2"
            ),
            "LKR" => array(
                "Num" => "144",
                "exponent" => "2"
            ),
            "LRD" => array(
                "Num" => "430",
                "exponent" => "2"
            ),
            "LSL" => array(
                "Num" => "426",
                "exponent" => "2"
            ),
            "MAD" => array(
                "Num" => "504",
                "exponent" => "2"
            ),
            "MDL" => array(
                "Num" => "498",
                "exponent" => "2"
            ),
            "MKD" => array(
                "Num" => "807",
                "exponent" => "2"
            ),
            "MMK" => array(
                "Num" => "104",
                "exponent" => "2"
            ),
            "MNT" => array(
                "Num" => "496",
                "exponent" => "2"
            ),
            "MOP" => array(
                "Num" => "446",
                "exponent" => "2"
            ),
            "MUR" => array(
                "Num" => "480",
                "exponent" => "2"
            ),
            "MVR" => array(
                "Num" => "462",
                "exponent" => "2"
            ),
            "MWK" => array(
                "Num" => "454",
                "exponent" => "2"
            ),
            "MXN" => array(
                "Num" => "484",
                "exponent" => "2"
            ),
            "MXV" => array(
                "Num" => "979",
                "exponent" => "2"
            ),
            "MYR" => array(
                "Num" => "458",
                "exponent" => "2"
            ),
            "MZN" => array(
                "Num" => "943",
                "exponent" => "2"
            ),
            "NAD" => array(
                "Num" => "516",
                "exponent" => "2"
            ),
            "NGN" => array(
                "Num" => "566",
                "exponent" => "2"
            ),
            "NIO" => array(
                "Num" => "558",
                "exponent" => "2"
            ),
            "NOK" => array(
                "Num" => "578",
                "exponent" => "2"
            ),
            "NPR" => array(
                "Num" => "524",
                "exponent" => "2"
            ),
            "NZD" => array(
                "Num" => "554",
                "exponent" => "2"
            ),
            "PAB" => array(
                "Num" => "590",
                "exponent" => "2"
            ),
            "PEN" => array(
                "Num" => "604",
                "exponent" => "2"
            ),
            "PGK" => array(
                "Num" => "598",
                "exponent" => "2"
            ),
            "PHP" => array(
                "Num" => "608",
                "exponent" => "2"
            ),
            "PKR" => array(
                "Num" => "586",
                "exponent" => "2"
            ),
            "PLN" => array(
                "Num" => "985",
                "exponent" => "2"
            ),
            "QAR" => array(
                "Num" => "634",
                "exponent" => "2"
            ),
            "RON" => array(
                "Num" => "946",
                "exponent" => "2"
            ),
            "RSD" => array(
                "Num" => "941",
                "exponent" => "2"
            ),
            "RUB" => array(
                "Num" => "643",
                "exponent" => "2"
            ),
            "SAR" => array(
                "Num" => "682",
                "exponent" => "2"
            ),
            "SBD" => array(
                "Num" => "090",
                "exponent" => "2"
            ),
            "SCR" => array(
                "Num" => "690",
                "exponent" => "2"
            ),
            "SDG" => array(
                "Num" => "938",
                "exponent" => "2"
            ),
            "SEK" => array(
                "Num" => "752",
                "exponent" => "2"
            ),
            "SGD" => array(
                "Num" => "702",
                "exponent" => "2"
            ),
            "SHP" => array(
                "Num" => "654",
                "exponent" => "2"
            ),
            "SLL" => array(
                "Num" => "694",
                "exponent" => "2"
            ),
            "SOS" => array(
                "Num" => "706",
                "exponent" => "2"
            ),
            "SRD" => array(
                "Num" => "968",
                "exponent" => "2"
            ),
            "SSP" => array(
                "Num" => "728",
                "exponent" => "2"
            ),
            "STD" => array(
                "Num" => "678",
                "exponent" => "2"
            ),
            "SVC" => array(
                "Num" => "222",
                "exponent" => "2"
            ),
            "SYP" => array(
                "Num" => "760",
                "exponent" => "2"
            ),
            "SZL" => array(
                "Num" => "748",
                "exponent" => "2"
            ),
            "THB" => array(
                "Num" => "764",
                "exponent" => "2"
            ),
            "TJS" => array(
                "Num" => "972",
                "exponent" => "2"
            ),
            "TMT" => array(
                "Num" => "934",
                "exponent" => "2"
            ),
            "TOP" => array(
                "Num" => "776",
                "exponent" => "2"
            ),
            "TRY" => array(
                "Num" => "949",
                "exponent" => "2"
            ),
            "TTD" => array(
                "Num" => "780",
                "exponent" => "2"
            ),
            "TWD" => array(
                "Num" => "901",
                "exponent" => "2"
            ),
            "TZS" => array(
                "Num" => "834",
                "exponent" => "2"
            ),
            "UAH" => array(
                "Num" => "980",
                "exponent" => "2"
            ),
            "USD" => array(
                "Num" => "840",
                "exponent" => "2"
            ),
            "USN" => array(
                "Num" => "997",
                "exponent" => "2"
            ),
            "UYU" => array(
                "Num" => "858",
                "exponent" => "2"
            ),
            "UZS" => array(
                "Num" => "860",
                "exponent" => "2"
            ),
            "VEF" => array(
                "Num" => "937",
                "exponent" => "2"
            ),
            "WST" => array(
                "Num" => "882",
                "exponent" => "2"
            ),
            "XCD" => array(
                "Num" => "951",
                "exponent" => "2"
            ),
            "YER" => array(
                "Num" => "886",
                "exponent" => "2"
            ),
            "ZAR" => array(
                "Num" => "710",
                "exponent" => "2"
            ),
            "ZMW" => array(
                "Num" => "967",
                "exponent" => "2"
            ),
            "ZWL" => array(
                "Num" => "932",
                "exponent" => "2"
            ),
            "MGA" => array(
                "Num" => "969",
                "exponent" => "1"
            ),
            "MRO" => array(
                "Num" => "478",
                "exponent" => "1"
            ),
            "BIF" => array(
                "Num" => "108",
                "exponent" => "0"
            ),
            "BYR" => array(
                "Num" => "974",
                "exponent" => "0"
            ),
            "CLP" => array(
                "Num" => "152",
                "exponent" => "0"
            ),
            "CVE" => array(
                "Num" => "132",
                "exponent" => "0"
            ),
            "DJF" => array(
                "Num" => "262",
                "exponent" => "0"
            ),
            "GNF" => array(
                "Num" => "324",
                "exponent" => "0"
            ),
            "ISK" => array(
                "Num" => "352",
                "exponent" => "0"
            ),
            "JPY" => array(
                "Num" => "392",
                "exponent" => "0"
            ),
            "KMF" => array(
                "Num" => "174",
                "exponent" => "0"
            ),
            "KRW" => array(
                "Num" => "410",
                "exponent" => "0"
            ),
            "PYG" => array(
                "Num" => "600",
                "exponent" => "0"
            ),
            "RWF" => array(
                "Num" => "646",
                "exponent" => "0"
            ),
            "UGX" => array(
                "Num" => "800",
                "exponent" => "0"
            ),
            "UYI" => array(
                "Num" => "940",
                "exponent" => "0"
            ),
            "VND" => array(
                "Num" => "704",
                "exponent" => "0"
            ),
            "VUV" => array(
                "Num" => "548",
                "exponent" => "0"
            ),
            "XAF" => array(
                "Num" => "950",
                "exponent" => "0"
            ),
            "XOF" => array(
                "Num" => "952",
                "exponent" => "0"
            ),
            "XPF" => array(
                "Num" => "953",
                "exponent" => "0"
            )
        );
    }


}