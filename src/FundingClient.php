<?php

declare(strict_types=1);

namespace SixMm\Funding;

use Asset_service as Proto;
use Google\Protobuf\Internal\Message;
use Grpc\ChannelCredentials;
use InvalidArgumentException;
use SixMm\Funding\Exception\RpcException;
use UnexpectedValueException;

final class FundingClient
{
    private Proto\AssetServiceClient $client;
    private int $timeoutMicroseconds;
    private array $metadata;

    /** @param array<string, list<string>> $metadata */
    public function __construct(Proto\AssetServiceClient $client, int $timeoutMilliseconds = 8000, array $metadata = [])
    {
        if ($timeoutMilliseconds < 1 || $timeoutMilliseconds > intdiv(PHP_INT_MAX, 1000)) {
            throw new InvalidArgumentException('Funding RPC timeout must be a positive number of milliseconds.');
        }
        $this->client = $client;
        $this->timeoutMicroseconds = $timeoutMilliseconds * 1000;
        $this->metadata = $metadata;
    }

    /** @param array<string, list<string>> $metadata */
    public static function connect(string $target, int $timeoutMilliseconds = 8000, array $channelOptions = [], array $metadata = []): self
    {
        if (trim($target) === '' || $target !== trim($target)) {
            throw new InvalidArgumentException('Funding gRPC target must be configured without surrounding whitespace.');
        }
        // createInsecure() returns null, which is an explicit channel configuration.
        if (!array_key_exists('credentials', $channelOptions)) {
            $channelOptions['credentials'] = ChannelCredentials::createSsl();
        }
        $channelOptions['grpc.enable_retries'] = 0;

        return new self(new Proto\AssetServiceClient($target, $channelOptions), $timeoutMilliseconds, $metadata);
    }

    public function ping(Proto\PingRequest $request, array $metadata = []): Proto\PingResponse
    {
        return $this->invoke('Ping', $request, Proto\PingResponse::class, $metadata);
    }

    public function createFundingAsset(Proto\CreateFundingAssetRequest $request, array $metadata = []): Proto\CreateFundingAssetResponse
    {
        return $this->invoke('CreateFundingAsset', $request, Proto\CreateFundingAssetResponse::class, $metadata);
    }

    public function changeFundingAssetStatus(Proto\ChangeFundingAssetStatusRequest $request, array $metadata = []): Proto\ChangeFundingAssetStatusResponse
    {
        return $this->invoke('ChangeFundingAssetStatus', $request, Proto\ChangeFundingAssetStatusResponse::class, $metadata);
    }

    public function getFundingAsset(Proto\GetFundingAssetRequest $request, array $metadata = []): Proto\GetFundingAssetResponse
    {
        return $this->invoke('GetFundingAsset', $request, Proto\GetFundingAssetResponse::class, $metadata);
    }

    public function listFundingAssets(Proto\ListFundingAssetsRequest $request, array $metadata = []): Proto\ListFundingAssetsResponse
    {
        return $this->invoke('ListFundingAssets', $request, Proto\ListFundingAssetsResponse::class, $metadata);
    }

    public function getFundingAccount(Proto\GetFundingAccountRequest $request, array $metadata = []): Proto\GetFundingAccountResponse
    {
        return $this->invoke('GetFundingAccount', $request, Proto\GetFundingAccountResponse::class, $metadata);
    }

    public function getFundingBalance(Proto\GetFundingBalanceRequest $request, array $metadata = []): Proto\GetFundingBalanceResponse
    {
        return $this->invoke('GetFundingBalance', $request, Proto\GetFundingBalanceResponse::class, $metadata);
    }

    public function listFundingBalances(Proto\ListFundingBalancesRequest $request, array $metadata = []): Proto\ListFundingBalancesResponse
    {
        return $this->invoke('ListFundingBalances', $request, Proto\ListFundingBalancesResponse::class, $metadata);
    }

    public function creditDeposit(Proto\CreditDepositRequest $request, array $metadata = []): Proto\CreditDepositResponse
    {
        return $this->invoke('CreditDeposit', $request, Proto\CreditDepositResponse::class, $metadata);
    }

    public function creditFunding(Proto\FundingBusinessMutationRequest $request, array $metadata = []): Proto\FundingBusinessMutationResponse
    {
        return $this->invoke('CreditFunding', $request, Proto\FundingBusinessMutationResponse::class, $metadata);
    }

    public function debitFunding(Proto\FundingBusinessMutationRequest $request, array $metadata = []): Proto\FundingBusinessMutationResponse
    {
        return $this->invoke('DebitFunding', $request, Proto\FundingBusinessMutationResponse::class, $metadata);
    }

    public function batchApplyFundingMutations(Proto\BatchApplyFundingMutationsRequest $request, array $metadata = []): Proto\BatchApplyFundingMutationsResponse
    {
        return $this->invoke('BatchApplyFundingMutations', $request, Proto\BatchApplyFundingMutationsResponse::class, $metadata);
    }

    public function createFundingHold(Proto\CreateFundingHoldRequest $request, array $metadata = []): Proto\FundingHoldMutationResponse
    {
        return $this->invoke('CreateFundingHold', $request, Proto\FundingHoldMutationResponse::class, $metadata);
    }

    public function captureFundingHold(Proto\CaptureFundingHoldRequest $request, array $metadata = []): Proto\FundingHoldMutationResponse
    {
        return $this->invoke('CaptureFundingHold', $request, Proto\FundingHoldMutationResponse::class, $metadata);
    }

    public function releaseFundingHold(Proto\ReleaseFundingHoldRequest $request, array $metadata = []): Proto\FundingHoldMutationResponse
    {
        return $this->invoke('ReleaseFundingHold', $request, Proto\FundingHoldMutationResponse::class, $metadata);
    }

    public function createWithdrawalHold(Proto\CreateWithdrawalHoldRequest $request, array $metadata = []): Proto\CreateWithdrawalHoldResponse
    {
        return $this->invoke('CreateWithdrawalHold', $request, Proto\CreateWithdrawalHoldResponse::class, $metadata);
    }

    public function settleWithdrawalHold(Proto\SettleWithdrawalHoldRequest $request, array $metadata = []): Proto\SettleWithdrawalHoldResponse
    {
        return $this->invoke('SettleWithdrawalHold', $request, Proto\SettleWithdrawalHoldResponse::class, $metadata);
    }

    public function releaseWithdrawalHold(Proto\ReleaseWithdrawalHoldRequest $request, array $metadata = []): Proto\ReleaseWithdrawalHoldResponse
    {
        return $this->invoke('ReleaseWithdrawalHold', $request, Proto\ReleaseWithdrawalHoldResponse::class, $metadata);
    }

    public function getFundingHold(Proto\GetFundingHoldRequest $request, array $metadata = []): Proto\GetFundingHoldResponse
    {
        return $this->invoke('GetFundingHold', $request, Proto\GetFundingHoldResponse::class, $metadata);
    }

    public function listFundingHolds(Proto\ListFundingHoldsRequest $request, array $metadata = []): Proto\ListFundingHoldsResponse
    {
        return $this->invoke('ListFundingHolds', $request, Proto\ListFundingHoldsResponse::class, $metadata);
    }

    public function listFundingLedgerEntries(Proto\ListFundingLedgerEntriesRequest $request, array $metadata = []): Proto\ListFundingLedgerEntriesResponse
    {
        return $this->invoke('ListFundingLedgerEntries', $request, Proto\ListFundingLedgerEntriesResponse::class, $metadata);
    }

    public function getFundingCommandResult(Proto\GetFundingCommandResultRequest $request, array $metadata = []): Proto\GetFundingCommandResultResponse
    {
        return $this->invoke('GetFundingCommandResult', $request, Proto\GetFundingCommandResultResponse::class, $metadata);
    }

    public function createFundingAdjustment(Proto\CreateFundingAdjustmentRequest $request, array $metadata = []): Proto\CreateFundingAdjustmentResponse
    {
        return $this->invoke('CreateFundingAdjustment', $request, Proto\CreateFundingAdjustmentResponse::class, $metadata);
    }

    public function reviewFundingAdjustment(Proto\ReviewFundingAdjustmentRequest $request, array $metadata = []): Proto\ReviewFundingAdjustmentResponse
    {
        return $this->invoke('ReviewFundingAdjustment', $request, Proto\ReviewFundingAdjustmentResponse::class, $metadata);
    }

    public function getFundingAdjustment(Proto\GetFundingAdjustmentRequest $request, array $metadata = []): Proto\GetFundingAdjustmentResponse
    {
        return $this->invoke('GetFundingAdjustment', $request, Proto\GetFundingAdjustmentResponse::class, $metadata);
    }

    public function listFundingAdjustments(Proto\ListFundingAdjustmentsRequest $request, array $metadata = []): Proto\ListFundingAdjustmentsResponse
    {
        return $this->invoke('ListFundingAdjustments', $request, Proto\ListFundingAdjustmentsResponse::class, $metadata);
    }

    public function createAccountTransfer(Proto\CreateAccountTransferRequest $request, array $metadata = []): Proto\CreateAccountTransferResponse
    {
        return $this->invoke('CreateAccountTransfer', $request, Proto\CreateAccountTransferResponse::class, $metadata);
    }

    public function creditFundingTransfer(Proto\CreditFundingTransferRequest $request, array $metadata = []): Proto\CreditFundingTransferResponse
    {
        return $this->invoke('CreditFundingTransfer', $request, Proto\CreditFundingTransferResponse::class, $metadata);
    }

    public function getFundingTransfer(Proto\GetFundingTransferRequest $request, array $metadata = []): Proto\GetFundingTransferResponse
    {
        return $this->invoke('GetFundingTransfer', $request, Proto\GetFundingTransferResponse::class, $metadata);
    }

    public function listFundingTransfers(Proto\ListFundingTransfersRequest $request, array $metadata = []): Proto\ListFundingTransfersResponse
    {
        return $this->invoke('ListFundingTransfers', $request, Proto\ListFundingTransfersResponse::class, $metadata);
    }

    public function resolveFundingTransfer(Proto\ResolveFundingTransferRequest $request, array $metadata = []): Proto\ResolveFundingTransferResponse
    {
        return $this->invoke('ResolveFundingTransfer', $request, Proto\ResolveFundingTransferResponse::class, $metadata);
    }

    public function close(): void
    {
        $this->client->close();
    }

    /**
     * @template T of Message
     * @param class-string<T> $responseClass
     * @return T
     */
    private function invoke(string $method, Message $request, string $responseClass, array $metadata): Message
    {
        [$response, $status] = $this->client->{$method}(
            $request,
            array_replace($this->metadata, $metadata),
            ['timeout' => $this->timeoutMicroseconds]
        )->wait();

        $code = (int) ($status->code ?? \Grpc\STATUS_UNKNOWN);
        if ($code !== \Grpc\STATUS_OK) {
            throw new RpcException($method, $code, (string) ($status->details ?? 'Unknown gRPC status'));
        }
        if (!$response instanceof $responseClass) {
            throw new UnexpectedValueException('Funding RPC ' . $method . ' returned an unexpected response type.');
        }

        // Transport success is not business success; preserve result_status and result_code.
        return $response;
    }
}
