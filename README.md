# 6MM Funding PHP SDK

`zhangjinteng/6mm-funding` packages all 31 unary RPCs in
`proto/asset_service.proto`. It includes the generated `Asset_service` messages,
enums and `AssetServiceClient`, plus the synchronous `SixMm\Funding\FundingClient`.
The upstream protobuf package, field numbers and RPC paths are unchanged.

## Requirements

- PHP 8.1 or newer, with `ext-grpc`.
- Composer dependencies `google/protobuf` and `grpc/grpc`.
- `protoc` and `grpc_php_plugin` only when regenerating code.

## Usage

```php
use Asset_service\GetFundingBalanceRequest;
use SixMm\Funding\FundingClient;

// TLS is enabled by default. Supply the upstream's real authentication metadata.
$client = FundingClient::connect($address, 8000, [], $metadata);
$request = (new GetFundingBalanceRequest())
    ->setHomeSiteId('site-1')
    ->setUserId('9007199254740993')
    ->setAssetCode('USDT');

try {
    $response = $client->getFundingBalance($request);
    $balance = $response->getBalance();
} finally {
    $client->close();
}
```

The synchronous method names are the RPC names with a lowercase first letter,
for example `listFundingLedgerEntries`, `createFundingAdjustment` and
`resolveFundingTransfer`. Every method takes its generated request message and
optional per-call metadata. Per-call metadata replaces matching default keys.
The generated `Asset_service\AssetServiceClient` remains available for raw gRPC
calls and explicit `wait()` handling.

For server-side `CreateFundingAdjustment` and `ReviewFundingAdjustment`, the
supplied upstream contract requires `['x-tk-service' => ['admin']]` metadata. The
SDK remains service-neutral; pass this metadata when constructing an admin client.
The platform integration configures it automatically. The verified internal target
`192.168.10.240:15070` uses plaintext gRPC, so use an explicitly configured
`ChannelCredentials::createInsecure()` for that target only; TLS remains the default.

## Money And Command Semantics

- Amounts remain decimal strings. Do not convert amounts or int64 identifiers to
  floating point numbers. `home_site_id` is a string in this protocol.
- `FundingBusinessMutationRequest::hasAgentId()` distinguishes an omitted
  `agent_id` from an explicit zero. The SDK does not fill this field automatically.
- `FundingClient::connect()` disables gRPC retries and the wrapper never retries
  calls. If supplying an existing generated client to the constructor, configure
  its channel with `grpc.enable_retries = 0` too.
- Transport failures throw `SixMm\Funding\Exception\RpcException`. A timeout or
  disconnect is not proof that a write did not execute. Persist command identities
  in the caller, retain the original parameters and query `getFundingCommandResult`
  before deciding how to proceed. The SDK does not generate replacement IDs.
- Transport success does not mean business success. Inspect `result_status` and
  `result_code`; `ACCEPTED` is not final success and `REJECTED` is a business result.
- Preserve upstream versions, opaque page tokens, pagination modes and business
  scopes. Do not infer transfer resolution from a missing downstream result.
- Batch results must be correlated using command IDs, not response order.

## Regeneration And Tests

```sh
composer install
composer generate
composer test
```

`PROTOC` and `GRPC_PHP_PLUGIN` can override the compiler/plugin executables.
Generated files must not be edited manually. The proto is the source of truth;
when its RPC list changes, update the synchronous wrapper and run the tests, which
check each RPC's path and request/response types. Tests use mocked gRPC calls and
never issue financial requests.

To run SDK tests using the existing platform dependencies without a separate
SDK vendor directory, run from `platform/platform_admin`:

```sh
php vendor/bin/phpunit --do-not-cache-result --bootstrap vendor/autoload.php ../../agent/6mm-funding/tests
```
