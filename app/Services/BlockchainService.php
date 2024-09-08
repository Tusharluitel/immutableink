<?php

namespace App\Services;

use Web3\Web3;
use Web3\Contract;

class BlockchainService
{
    protected $web3;
    protected $contract;

    public function __construct()
    {
        // $this->web3 = new Web3(env('INFURA'));
        // $this->contract = new Contract($this->web3->provider, env('CONTRACT_ABI'));
        // $this->contract->at(env('CONTRACT_ADDRESS'));
    }

    public function addFile($fileHash, $link)
    {
        $this->contract->send('addFile', $fileHash, $link, function ($err, $transaction) {
            if ($err) {
                throw new \Exception($err->getMessage());
            }
        });
    }

    public function getFiles()
    {
        $this->contract->call('getFiles', function ($err, $result) {
            if ($err) {
                throw new \Exception($err->getMessage());
            }
            return $result;
        });
    }
}
