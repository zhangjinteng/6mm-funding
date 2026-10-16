<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Asset_service;

/**
 */
class AssetServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Asset_service\PingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\PingResponse>
     */
    public function Ping(\Asset_service\PingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/Ping',
        $argument,
        ['\Asset_service\PingResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\CreateFundingAssetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\CreateFundingAssetResponse>
     */
    public function CreateFundingAsset(\Asset_service\CreateFundingAssetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/CreateFundingAsset',
        $argument,
        ['\Asset_service\CreateFundingAssetResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\ChangeFundingAssetStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\ChangeFundingAssetStatusResponse>
     */
    public function ChangeFundingAssetStatus(\Asset_service\ChangeFundingAssetStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/ChangeFundingAssetStatus',
        $argument,
        ['\Asset_service\ChangeFundingAssetStatusResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\GetFundingAssetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\GetFundingAssetResponse>
     */
    public function GetFundingAsset(\Asset_service\GetFundingAssetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/GetFundingAsset',
        $argument,
        ['\Asset_service\GetFundingAssetResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\ListFundingAssetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\ListFundingAssetsResponse>
     */
    public function ListFundingAssets(\Asset_service\ListFundingAssetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/ListFundingAssets',
        $argument,
        ['\Asset_service\ListFundingAssetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\GetFundingAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\GetFundingAccountResponse>
     */
    public function GetFundingAccount(\Asset_service\GetFundingAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/GetFundingAccount',
        $argument,
        ['\Asset_service\GetFundingAccountResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\GetFundingBalanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\GetFundingBalanceResponse>
     */
    public function GetFundingBalance(\Asset_service\GetFundingBalanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/GetFundingBalance',
        $argument,
        ['\Asset_service\GetFundingBalanceResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\ListFundingBalancesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\ListFundingBalancesResponse>
     */
    public function ListFundingBalances(\Asset_service\ListFundingBalancesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/ListFundingBalances',
        $argument,
        ['\Asset_service\ListFundingBalancesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\CreditDepositRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\CreditDepositResponse>
     */
    public function CreditDeposit(\Asset_service\CreditDepositRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/CreditDeposit',
        $argument,
        ['\Asset_service\CreditDepositResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\FundingBusinessMutationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\FundingBusinessMutationResponse>
     */
    public function CreditFunding(\Asset_service\FundingBusinessMutationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/CreditFunding',
        $argument,
        ['\Asset_service\FundingBusinessMutationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\FundingBusinessMutationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\FundingBusinessMutationResponse>
     */
    public function DebitFunding(\Asset_service\FundingBusinessMutationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/DebitFunding',
        $argument,
        ['\Asset_service\FundingBusinessMutationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\BatchApplyFundingMutationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\BatchApplyFundingMutationsResponse>
     */
    public function BatchApplyFundingMutations(\Asset_service\BatchApplyFundingMutationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/BatchApplyFundingMutations',
        $argument,
        ['\Asset_service\BatchApplyFundingMutationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\CreateFundingHoldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\FundingHoldMutationResponse>
     */
    public function CreateFundingHold(\Asset_service\CreateFundingHoldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/CreateFundingHold',
        $argument,
        ['\Asset_service\FundingHoldMutationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\CaptureFundingHoldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\FundingHoldMutationResponse>
     */
    public function CaptureFundingHold(\Asset_service\CaptureFundingHoldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/CaptureFundingHold',
        $argument,
        ['\Asset_service\FundingHoldMutationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\ReleaseFundingHoldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\FundingHoldMutationResponse>
     */
    public function ReleaseFundingHold(\Asset_service\ReleaseFundingHoldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/ReleaseFundingHold',
        $argument,
        ['\Asset_service\FundingHoldMutationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\CreateWithdrawalHoldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\CreateWithdrawalHoldResponse>
     */
    public function CreateWithdrawalHold(\Asset_service\CreateWithdrawalHoldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/CreateWithdrawalHold',
        $argument,
        ['\Asset_service\CreateWithdrawalHoldResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\SettleWithdrawalHoldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\SettleWithdrawalHoldResponse>
     */
    public function SettleWithdrawalHold(\Asset_service\SettleWithdrawalHoldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/SettleWithdrawalHold',
        $argument,
        ['\Asset_service\SettleWithdrawalHoldResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\ReleaseWithdrawalHoldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\ReleaseWithdrawalHoldResponse>
     */
    public function ReleaseWithdrawalHold(\Asset_service\ReleaseWithdrawalHoldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/ReleaseWithdrawalHold',
        $argument,
        ['\Asset_service\ReleaseWithdrawalHoldResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\GetFundingHoldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\GetFundingHoldResponse>
     */
    public function GetFundingHold(\Asset_service\GetFundingHoldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/GetFundingHold',
        $argument,
        ['\Asset_service\GetFundingHoldResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\ListFundingHoldsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\ListFundingHoldsResponse>
     */
    public function ListFundingHolds(\Asset_service\ListFundingHoldsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/ListFundingHolds',
        $argument,
        ['\Asset_service\ListFundingHoldsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\ListFundingLedgerEntriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\ListFundingLedgerEntriesResponse>
     */
    public function ListFundingLedgerEntries(\Asset_service\ListFundingLedgerEntriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/ListFundingLedgerEntries',
        $argument,
        ['\Asset_service\ListFundingLedgerEntriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\GetFundingCommandResultRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\GetFundingCommandResultResponse>
     */
    public function GetFundingCommandResult(\Asset_service\GetFundingCommandResultRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/GetFundingCommandResult',
        $argument,
        ['\Asset_service\GetFundingCommandResultResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\CreateFundingAdjustmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\CreateFundingAdjustmentResponse>
     */
    public function CreateFundingAdjustment(\Asset_service\CreateFundingAdjustmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/CreateFundingAdjustment',
        $argument,
        ['\Asset_service\CreateFundingAdjustmentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\ReviewFundingAdjustmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\ReviewFundingAdjustmentResponse>
     */
    public function ReviewFundingAdjustment(\Asset_service\ReviewFundingAdjustmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/ReviewFundingAdjustment',
        $argument,
        ['\Asset_service\ReviewFundingAdjustmentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\GetFundingAdjustmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\GetFundingAdjustmentResponse>
     */
    public function GetFundingAdjustment(\Asset_service\GetFundingAdjustmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/GetFundingAdjustment',
        $argument,
        ['\Asset_service\GetFundingAdjustmentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\ListFundingAdjustmentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\ListFundingAdjustmentsResponse>
     */
    public function ListFundingAdjustments(\Asset_service\ListFundingAdjustmentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/ListFundingAdjustments',
        $argument,
        ['\Asset_service\ListFundingAdjustmentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\CreateAccountTransferRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\CreateAccountTransferResponse>
     */
    public function CreateAccountTransfer(\Asset_service\CreateAccountTransferRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/CreateAccountTransfer',
        $argument,
        ['\Asset_service\CreateAccountTransferResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\CreditFundingTransferRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\CreditFundingTransferResponse>
     */
    public function CreditFundingTransfer(\Asset_service\CreditFundingTransferRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/CreditFundingTransfer',
        $argument,
        ['\Asset_service\CreditFundingTransferResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\GetFundingTransferRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\GetFundingTransferResponse>
     */
    public function GetFundingTransfer(\Asset_service\GetFundingTransferRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/GetFundingTransfer',
        $argument,
        ['\Asset_service\GetFundingTransferResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\ListFundingTransfersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\ListFundingTransfersResponse>
     */
    public function ListFundingTransfers(\Asset_service\ListFundingTransfersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/ListFundingTransfers',
        $argument,
        ['\Asset_service\ListFundingTransfersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Asset_service\ResolveFundingTransferRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Asset_service\ResolveFundingTransferResponse>
     */
    public function ResolveFundingTransfer(\Asset_service\ResolveFundingTransferRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/asset_service.AssetService/ResolveFundingTransfer',
        $argument,
        ['\Asset_service\ResolveFundingTransferResponse', 'decode'],
        $metadata, $options);
    }

}
