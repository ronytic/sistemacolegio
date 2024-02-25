<?php
require_once '../../class/config.php';
class Core
{
    protected $config;
    function __construct()
    {
        $this->config = new config;
    }
    function getToken($SFEUrl = '', $SFEUsuario = '', $SFEContrasena = '')
    {
        if (empty($SFEUrl)) {
            $SFEUrl = $this->config->mostrarConfig('SFEUrl', 1);
        }
        if (empty($SFEUsuario)) {
            $SFEUsuario = $this->config->mostrarConfig('SFEUsuario', 1);
        }
        if (empty($SFEContrasena)) {
            $SFEContrasena = $this->config->mostrarConfig('SFEContrasena', 1);
        }
        $url = $SFEUrl . "/login";
        $data = array(
            "username" => $SFEUsuario,
            "password" => $SFEContrasena
        );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $resultado = json_decode($result, true);
        if ($resultado['status']) {
            $this->config->revisar('SFEToken', $resultado['token']);
            $this->config->revisar('SFEValidezToken', $resultado['expires_at']);
        }
        return $resultado;
    }

    function getSystems($SFEToken = '')
    {
        if (empty($SFEToken)) {
            $SFEToken = $this->config->mostrarConfig('SFEToken', 1);
        }
        $url = $this->config->mostrarConfig('SFEUrl', 1) . "/systems/list";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Authorization: Bearer ' . $SFEToken
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $resultado = json_decode($result, true);
        if ($resultado['status']) {
            if (count($resultado['data']) == 1) {
                $this->config->revisar('SFEIdSistema', $resultado['data'][0]['id_siat_system']);
            }
        }
        return $resultado;
    }
    function getBranches($SFEToken = '')
    {
        if (empty($SFEToken)) {
            $SFEToken = $this->config->mostrarConfig('SFEToken', 1);
        }
        $url = $this->config->mostrarConfig('SFEUrl', 1) . "/branches";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Authorization: Bearer ' . $SFEToken
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $resultado = json_decode($result, true);
        // return $resultado;
        if ($resultado['status']) {
            if (count($resultado['data']) == 1) {
                $this->config->revisar('SFECodSucursal', $resultado['data'][0]['siat_number_branch']);
            }
        }
        return $resultado;
    }
    function getPoses($SFEToken = '', $SFECodSucursal = '')
    {
        if (empty($SFEToken)) {
            $SFEToken = $this->config->mostrarConfig('SFEToken', 1);
        }
        if (empty($SFECodSucursal)) {
            $SFECodSucursal = $this->config->mostrarConfig('SFECodSucursal', 1);
        }
        $url = $this->config->mostrarConfig('SFEUrl', 1) . "/pos/internal";
        $data = array(
            "siat_number_branch" => $SFECodSucursal
        );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Authorization: Bearer ' . $SFEToken,
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $resultado = json_decode($result, true);
        // return $resultado;
        if ($resultado['status']) {
            if (count($resultado['data']) == 1) {
                $this->config->revisar('SFECodSucursal', "'" . $resultado['data'][0]['siat_number_branch'] . "'");
            }
        }
        return $resultado;
    }
    function getPaymentMethods($SFEToken = '', $SFECodSucursal = '')
    {
        if (empty($SFEToken)) {
            $SFEToken = $this->config->mostrarConfig('SFEToken', 1);
        }
        if (empty($SFECodSucursal)) {
            $SFECodSucursal = $this->config->mostrarConfig('SFECodSucursal', 1);
        }
        $url = $this->config->mostrarConfig('SFEUrl', 1) . "/synchronization/internal/paymentmethods";
        $data = array(
            "siat_number_branch" => $SFECodSucursal,
            "siat_code_pos" => 0
        );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $SFEToken,
            'Content-Type: application/json',
            'Accept: application/json',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $resultado = json_decode($result, true);
        return $resultado;
        // if ($resultado['status']) {
        //     if (count($resultado['data']) == 1) {
        //         $this->config->revisar('SFECodSucursal', "'" . $resultado['data'][0]['siat_number_branch'] . "'");
        //     }
        // }
        // return $resultado;
    }
    function getCurrencyTypes($SFEToken = '', $SFECodSucursal = '')
    {
        if (empty($SFEToken)) {
            $SFEToken = $this->config->mostrarConfig('SFEToken', 1);
        }
        if (empty($SFECodSucursal)) {
            $SFECodSucursal = $this->config->mostrarConfig('SFECodSucursal', 1);
        }
        $url = $this->config->mostrarConfig('SFEUrl', 1) . "/synchronization/internal/currencytypes";
        $data = array(
            "siat_number_branch" => $SFECodSucursal,
            "siat_code_pos" => 0
        );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Authorization: Bearer ' . $SFEToken,
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $resultado = json_decode($result, true);
        return $resultado;
        // if ($resultado['status']) {
        //     if (count($resultado['data']) == 1) {
        //         $this->config->revisar('SFECodSucursal', "'" . $resultado['data'][0]['siat_number_branch'] . "'");
        //     }
        // }
        // return $resultado;
    }

    function getMeasurementUnits($SFEToken = '', $SFECodSucursal = '')
    {
        if (empty($SFEToken)) {
            $SFEToken = $this->config->mostrarConfig('SFEToken', 1);
        }
        if (empty($SFECodSucursal)) {
            $SFECodSucursal = $this->config->mostrarConfig('SFECodSucursal', 1);
        }
        $url = $this->config->mostrarConfig('SFEUrl', 1) . "/synchronization/internal/measurementunits";
        $data = array(
            "siat_number_branch" => $SFECodSucursal,
            "siat_code_pos" => 0
        );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Authorization: Bearer ' . $SFEToken,
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $resultado = json_decode($result, true);
        return $resultado;
        // if ($resultado['status']) {
        //     if (count($resultado['data']) == 1) {
        //         $this->config->revisar('SFECodSucursal', "'" . $resultado['data'][0]['siat_number_branch'] . "'");
        //     }
        // }
        // return $resultado;
    }

    function getActivities($SFEToken = '', $SFECodSucursal = '')
    {
        if (empty($SFEToken)) {
            $SFEToken = $this->config->mostrarConfig('SFEToken', 1);
        }
        if (empty($SFECodSucursal)) {
            $SFECodSucursal = $this->config->mostrarConfig('SFECodSucursal', 1);
        }
        $url = $this->config->mostrarConfig('SFEUrl', 1) . "/synchronization/internal/activities";
        $data = array(
            "siat_number_branch" => $SFECodSucursal,
            "siat_code_pos" => 0
        );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Authorization: Bearer ' . $SFEToken,
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $resultado = json_decode($result, true);
        return $resultado;
        // if ($resultado['status']) {
        //     if (count($resultado['data']) == 1) {
        //         $this->config->revisar('SFECodSucursal', "'" . $resultado['data'][0]['siat_number_branch'] . "'");
        //     }
        // }
        // return $resultado;
    }

    function getProductService($SFEToken = '', $SFECodSucursal = '', $SFECodActivity = '')
    {
        if (empty($SFEToken)) {
            $SFEToken = $this->config->mostrarConfig('SFEToken', 1);
        }
        if (empty($SFECodSucursal)) {
            $SFECodSucursal = $this->config->mostrarConfig('SFECodSucursal', 1);
        }
        if (empty($SFECodActivity)) {
            $SFECodActivity = $this->config->mostrarConfig('SFECodActivity', 1);
        }
        $url = $this->config->mostrarConfig('SFEUrl', 1) . "/synchronization/internal/productservices";
        $data = array(
            "siat_number_branch" => $SFECodSucursal,
            "siat_code_pos" => 0,
            "activity_code" => $SFECodActivity
        );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $SFEToken,
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $resultado = json_decode($result, true);
        return $resultado;
        // if ($resultado['status']) {
        //     if (count($resultado['data']) == 1) {
        //         $this->config->revisar('SFECodSucursal', "'" . $resultado['data'][0]['siat_number_branch'] . "'");
        //     }
        // }
        // return $resultado;
    }
}
