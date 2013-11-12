<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerWebservice extends ControllerAbstract
{

    /**
     * @todo Test
     */
    public function clientAction ()
    {

        /**
         * NUSOAP
         */
        include(__DIR__ . '/../../library/nusoap/lib/nusoap.php');

        /**
         * Instancia (Objeto/Servico) 
         */
        $client = new \nusoap_client('http://192.168.56.101/webservice/server/?wsdl/wsdl', 'wsdl');
//        $client->setEndpoint('http://192.168.56.101/webservice/server');
//$client->set
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            exit();
        }
        $client->setUseCurl(false);
        $client = $client->getProxy();
        $param = array(
            'a' => 18,
            'b' => 1
        );
        $result = $client->call('save'); //, $param, 'http://192.168.56.101/webserviceservers', 'urn:server#save');
// Check for a fault
        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        } else {
            // Check for errors
            $err = $client->getError();
            if ($err) {
                // Display the error
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                // Display the result
                echo '<h2>Result</h2><pre>';
                print_r($result);
                echo '</pre>';
            }
        }
        echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
        echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
        echo '<h2>Client Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
        echo '<h2>Proxy Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
    }

    /**
     * @todo Test
     * @return BusinessUsuario
     */
    public function serverAction ()
    {
        /**
         * NuSoap
         */
        include(__DIR__ . '/../../library/nusoap/lib/nusoap.php');

        $server = new \nusoap_server;
        $server->configureWSDL('server', 'urn:server');
        $server->wsdl->schemaTargetNamespace = 'urn:server';


        /* Registers */
        /* getHistoricoDocumento */
        $server->register('save', array('value' => 'xsd:array'), array('return' => 'xsd:struct'), 'urn:server', 'urn:server#save');

        /* getHistoricoProcesso */
        $server->register('create', array('value' => 'xsd:array'), array('return' => 'xsd:struct'), 'urn:server', 'urn:server#create');

        /**
         * Services List
         */
        function save ($a, $b)
        {
            return $a + $b;
        }

        function create ($a)
        {
            return $a + 'CREATE';
        }

        function delete ($a)
        {
            return $a . 'DELETE';
        }

        /**
         * Dispatch Service
         */
        $server->service(isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '');

        //  return $this;
    }

    public function sgdocAction ()
    {
        include(__DIR__ . '/../../library/nusoap/lib/nusoap.php');
        /* URL WebService */
        $url = "https://www3.icmbio.gov.br/sgdoc/protocolo-2.1.0-beta/nusoap/server.php";

        /* Instancia (Objeto/Servico) */
        $client = new \nusoap_client($url);

        /* Capturar Erro */
        $err = $client->getError();

        if ($err) {
            echo '<h2>Error</h2>';
            echo '<pre>' . htmlspecialchars($err, ENT_QUOTES) . '</pre>';
        }

        /* Invocacao Servico */
        $processo = $client->call('getHistoricoProcesso', array(array('numero_processo' => '02001.006536/2003-13', 'type' => 'json')));
        $documento = $client->call('getHistoricoDocumento', array(array('digital' => '0000002', 'type' => 'serial')));

        /* Print */
        if (!$err) {
            echo '<h2>Processo</h2>';
            echo '<pre>' . htmlspecialchars($processo, ENT_QUOTES) . '</pre>';
            echo '<h2>Documento</h2>';
            echo '<pre>' . htmlspecialchars($documento, ENT_QUOTES) . '</pre>';
        }
        echo '<h2>Request</h2>';
        echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
        echo '<h2>Response</h2>';
        echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
    }

    public function testAction ()
    {
        include(__DIR__ . '/../../library/nusoap/lib/nusoap.php');
        /* URL WebService */
        $url = "http://192.168.56.101/webservice/server";

        /* Instancia (Objeto/Servico) */
        $client = new \nusoap_client($url);

        /* Capturar Erro */
        $err = $client->getError();

        if ($err) {
            echo '<h2>Error</h2>';
            echo '<pre>' . htmlspecialchars($err, ENT_QUOTES) . '</pre>';
        }

        /* Invocacao Servico */
        $processo = $client->call('save', array(array('numero_processo' => '02001.006536/2003-13', 'type' => 'json')));
        $documento = $client->call('create', array(array('digital' => '0000002', 'type' => 'serial')));

        /* Print */
        if (!$err) {
            echo '<h2>Processo</h2>';
            echo '<pre>' . htmlspecialchars($processo, ENT_QUOTES) . '</pre>';
            echo '<h2>Documento</h2>';
            echo '<pre>' . htmlspecialchars($documento, ENT_QUOTES) . '</pre>';
        }
        echo '<h2>Request</h2>';
        echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
        echo '<h2>Response</h2>';
        echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
    }

}
