<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BscScanService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = 'E3B4XDN9WJK8GI9XXGPPMJJKR3ZEAFUWD8'; // Defina a chave no .env
        $this->baseUrl = 'https://api.bscscan.com/api';
        // https://api.bscscan.com/api?module=proxy&action=eth_getTransactionByHash&txhash={$txHash}&apikey={$apiKey}
    }

    /**
     * Obtém os detalhes completos da transação, incluindo tokens BEP20 transferidos.
     */
    public function getTransactionDetails($txHash)
    {
        $response = Http::get($this->baseUrl, [
            'module' => 'proxy',
            'action' => 'eth_getTransactionReceipt',
            'txhash' => $txHash,
            'apikey' => $this->apiKey
        ]);

        return $response->json();
    }

    /**
     * Valida se a transação foi confirmada e bem-sucedida.
     */
    public function validateTransaction($txHash)
    {
        $data = $this->getTransactionDetails($txHash);

        if (isset($data['status']) && $data['status'] == '1') {
            return true; // Transação confirmada
        }

        return false; // Transação não confirmada ou inválida
    }

    /**
     * Extrai os detalhes da transação, incluindo o valor do USDT e endereços corretos.
     */
    public function parseTransaction($txHash)
    {
        $data = $this->getTransactionDetails($txHash);

        if (!isset($data['result']) || empty($data['result']['logs'])) {
            return ['error' => 'Transaction not found or invalid logs'];
        }

        $logs = $data['result']['logs'];
        $tokenTransfers = [];

        foreach ($logs as $log) {
            // O contrato de USDT na BEP20 (pode ser atualizado conforme necessário)
            $usdtContract = '0x55d398326f99059ff775485246999027b3197955';

            if (isset($log['address']) && strtolower($log['address']) === strtolower($usdtContract)) {
                // O valor transferido está no `data`, precisa ser convertido
                $value = hexdec($log['data']) / (10 ** 18); // Convertendo de Wei para USDT

                // Pegando os endereços de envio e recebimento
                $from = '0x' . substr($log['topics'][1], 26);
                $to = '0x' . substr($log['topics'][2], 26);

                $tokenTransfers[] = [
                    'contract' => $log['address'],
                    'from' => $from,
                    'to' => $to,
                    'value' => $value
                ];
            }
        }

        return count($tokenTransfers) > 0 ? $tokenTransfers : ['error' => 'No USDT transfers found in this transaction'];
    }
}
