<?php

declare(strict_types=1);

namespace SixMm\Funding\Tests;

use Asset_service as Proto;
use Google\Protobuf\Internal\DescriptorPool;
use Google\Protobuf\Internal\Message;
use Grpc\CallInvoker;
use Grpc\UnaryCall;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use SixMm\Funding\Exception\RpcException;
use SixMm\Funding\FundingClient;

final class FundingClientTest extends TestCase
{
    public static function rpcMethods(): array
    {
        $methods = [];
        foreach ((new ReflectionClass(Proto\AssetServiceClient::class))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getDeclaringClass()->getName() !== Proto\AssetServiceClient::class || $method->getName() === '__construct') {
                continue;
            }
            preg_match('~UnaryCall<\\\\([^>]+)>~', $method->getDocComment(), $response);
            $methods[$method->getName()] = [
                $method->getName(),
                $method->getParameters()[0]->getType()->getName(),
                $response[1],
            ];
        }

        return $methods;
    }

    /** @dataProvider rpcMethods */
    public function testRpcPathTypesMetadataAndDeadline(string $method, string $requestClass, string $responseClass): void
    {
        $wrapper = new ReflectionMethod(FundingClient::class, lcfirst($method));
        self::assertSame($requestClass, $wrapper->getParameters()[0]->getType()->getName());
        self::assertSame($responseClass, $wrapper->getReturnType()->getName());
        $request = new $requestClass();
        $response = new $responseClass();
        $metadata = ['x-caller' => ['admin'], 'x-trace-id' => ['per-call']];
        $call = $this->getMockBuilder(UnaryCall::class)->disableOriginalConstructor()->onlyMethods(['start', 'wait'])->getMock();
        $call->expects(self::once())->method('start')->with(
            self::identicalTo($request), $metadata, ['timeout' => 1_234_000]
        );
        $call->expects(self::once())->method('wait')->willReturn([$response, (object) ['code' => 0, 'details' => '']]);
        $channel = new \stdClass();
        $invoker = $this->createMock(CallInvoker::class);
        $invoker->expects(self::once())->method('createChannelFactory')->with(
            'funding.test:50051',
            self::callback(static fn (array $options): bool => $options['grpc.enable_retries'] === 0
                && $options['credentials'] instanceof \Grpc\ChannelCredentials)
        )->willReturn($channel);
        $invoker->expects(self::once())->method('UnaryCall')->with(
            self::identicalTo($channel), '/asset_service.AssetService/' . $method,
            ['\\' . $responseClass, 'decode'], ['timeout' => 1_234_000]
        )->willReturn($call);

        $client = FundingClient::connect('funding.test:50051', 1234, [
            'grpc_call_invoker' => $invoker,
            'grpc.enable_retries' => 1,
        ], ['x-caller' => ['admin'], 'x-trace-id' => ['default']]);

        self::assertSame($response, $client->{$method}($request, ['x-trace-id' => ['per-call']]));
    }

    public function testAllThirtyOneRpcsAreExposed(): void
    {
        self::assertCount(31, self::rpcMethods());
        $methods = array_filter((new ReflectionClass(FundingClient::class))->getMethods(ReflectionMethod::IS_PUBLIC),
            static fn (ReflectionMethod $method): bool => !in_array($method->getName(), ['__construct', 'connect', 'close'], true));
        self::assertCount(31, $methods);
    }

    public function testExplicitPlaintextCredentialsAreNotReplacedWithTls(): void
    {
        $invoker = $this->createMock(CallInvoker::class);
        $invoker->expects(self::once())->method('createChannelFactory')->with(
            'funding.test:50051',
            self::callback(static fn (array $options): bool => array_key_exists('credentials', $options)
                && $options['credentials'] === null && $options['grpc.enable_retries'] === 0)
        )->willReturn(new \stdClass());

        self::assertInstanceOf(FundingClient::class, FundingClient::connect('funding.test:50051', 3000, [
            'credentials' => \Grpc\ChannelCredentials::createInsecure(),
            'grpc_call_invoker' => $invoker,
        ]));
    }

    public function testGeneratedMessagesHaveDescriptorsAndSupportWireRoundTrips(): void
    {
        $count = 0;
        foreach (glob(dirname(__DIR__) . '/src/Asset_service/*.php') as $file) {
            $class = 'Asset_service\\' . basename($file, '.php');
            if (!is_subclass_of($class, Message::class)) {
                continue;
            }
            $message = new $class();
            $decoded = new $class();
            $decoded->mergeFromString($message->serializeToString());
            self::assertSame($message->serializeToString(), $decoded->serializeToString());
            self::assertSame('asset_service.' . basename($file, '.php'),
                DescriptorPool::getGeneratedPool()->getDescriptorByClassName($class)->getFullName());
            $count++;
        }
        self::assertGreaterThan(60, $count);
    }

    public function testAmountInt64AndOptionalAgentPresenceArePreserved(): void
    {
        $request = (new Proto\FundingBusinessMutationRequest())
            ->setCommandId('9223372036854775807')
            ->setBusinessOperationId('9007199254740993')
            ->setBusinessScope('offline-test')
            ->setAmount('12345678901234567890.12345678');
        self::assertFalse($request->hasAgentId());
        $withoutAgent = $request->serializeToString();
        $request->setAgentId(0);
        self::assertTrue($request->hasAgentId());
        self::assertNotSame($withoutAgent, $request->serializeToString());

        $decoded = new Proto\FundingBusinessMutationRequest();
        $decoded->mergeFromString($request->serializeToString());
        self::assertSame('9223372036854775807', (string) $decoded->getCommandId());
        self::assertSame('9007199254740993', (string) $decoded->getBusinessOperationId());
        self::assertSame('12345678901234567890.12345678', $decoded->getAmount());
        self::assertTrue($decoded->hasAgentId());
        self::assertSame(0, $decoded->getAgentId());
        $decoded->clearAgentId();
        self::assertFalse($decoded->hasAgentId());
    }

    public function testAdjustmentJsonAcceptsStringIdentifiersAndNamedEnums(): void
    {
        $create = new Proto\CreateFundingAdjustmentRequest();
        $create->mergeFromJsonString(json_encode([
            'command_id' => '9007199254740993',
            'business_id' => '9007199254740994',
            'home_site_id' => '1001',
            'account_id' => '30001',
            'asset_code' => 'USDT',
            'direction' => 'FUNDING_ADJUSTMENT_DIRECTION_CREDIT',
            'amount' => '100.00000001',
            'reason_code' => 'MANUAL_CORRECTION',
            'reason_detail' => 'Offline serialization test only',
            'other_data_json' => '{"ticket_no":"OFFLINE-001"}',
            'operator_id' => '101',
        ], JSON_THROW_ON_ERROR));
        self::assertSame('9007199254740993', (string) $create->getCommandId());
        self::assertSame('9007199254740994', (string) $create->getBusinessId());
        self::assertSame(30001, $create->getAccountId());
        self::assertSame(Proto\FundingAdjustmentDirection::FUNDING_ADJUSTMENT_DIRECTION_CREDIT, $create->getDirection());
        self::assertSame('100.00000001', $create->getAmount());
        self::assertSame('{"ticket_no":"OFFLINE-001"}', $create->getOtherDataJson());

        $review = new Proto\ReviewFundingAdjustmentRequest();
        $review->mergeFromJsonString(json_encode([
            'command_id' => '9007199254740995',
            'adjustment_id' => '50001',
            'home_site_id' => '1001',
            'account_id' => '30001',
            'expected_version' => '7',
            'decision' => 'FUNDING_ADJUSTMENT_REVIEW_DECISION_APPROVE',
            'review_note' => 'Offline serialization test only',
            'operator_id' => '102',
        ], JSON_THROW_ON_ERROR));
        self::assertSame(7, $review->getExpectedVersion());
        self::assertSame(Proto\FundingAdjustmentReviewDecision::FUNDING_ADJUSTMENT_REVIEW_DECISION_APPROVE, $review->getDecision());
        self::assertNotSame($create->getCommandId(), $review->getCommandId());
        self::assertNotSame($create->getOperatorId(), $review->getOperatorId());
    }

    public static function transportFailures(): array
    {
        return [[\Grpc\STATUS_DEADLINE_EXCEEDED], [\Grpc\STATUS_UNAVAILABLE]];
    }

    /** @dataProvider transportFailures */
    public function testTransportFailureDoesNotRetryTheWrite(int $code): void
    {
        $request = new Proto\FundingBusinessMutationRequest(['command_id' => 123]);
        $call = $this->getMockBuilder(UnaryCall::class)->disableOriginalConstructor()->onlyMethods(['wait'])->getMock();
        $call->expects(self::once())->method('wait')->willReturn([null, (object) ['code' => $code, 'details' => 'offline failure']]);
        $stub = $this->getMockBuilder(Proto\AssetServiceClient::class)->disableOriginalConstructor()->onlyMethods(['CreditFunding'])->getMock();
        $stub->expects(self::once())->method('CreditFunding')->with(self::identicalTo($request), [], ['timeout' => 8_000_000])->willReturn($call);

        try {
            (new FundingClient($stub))->creditFunding($request);
            self::fail('Expected the RPC failure to be reported.');
        } catch (RpcException $exception) {
            self::assertSame($code, $exception->getCode());
            self::assertSame('CreditFunding', $exception->getMethod());
        }
    }

    public function testBusinessRejectedAndAcceptedAreNotReportedAsExecutionSuccess(): void
    {
        foreach ([Proto\CommandResultStatus::COMMAND_RESULT_STATUS_REJECTED, Proto\CommandResultStatus::COMMAND_RESULT_STATUS_ACCEPTED] as $status) {
            $response = new Proto\FundingBusinessMutationResponse(['result_status' => $status, 'result_code' => 'UPSTREAM_RESULT']);
            $call = $this->getMockBuilder(UnaryCall::class)->disableOriginalConstructor()->onlyMethods(['wait'])->getMock();
            $call->expects(self::once())->method('wait')->willReturn([$response, (object) ['code' => 0]]);
            $stub = $this->getMockBuilder(Proto\AssetServiceClient::class)->disableOriginalConstructor()->onlyMethods(['DebitFunding'])->getMock();
            $stub->expects(self::once())->method('DebitFunding')->willReturn($call);

            $result = (new FundingClient($stub))->debitFunding(new Proto\FundingBusinessMutationRequest());
            self::assertSame($response, $result);
            self::assertSame($status, $result->getResultStatus());
            self::assertSame('UPSTREAM_RESULT', $result->getResultCode());
        }
    }

    public function testInvalidResponseTypeIsRejected(): void
    {
        $call = $this->getMockBuilder(UnaryCall::class)->disableOriginalConstructor()->onlyMethods(['wait'])->getMock();
        $call->method('wait')->willReturn([new Proto\GetFundingAccountResponse(), (object) ['code' => 0]]);
        $stub = $this->getMockBuilder(Proto\AssetServiceClient::class)->disableOriginalConstructor()->onlyMethods(['Ping'])->getMock();
        $stub->method('Ping')->willReturn($call);

        $this->expectException(\UnexpectedValueException::class);
        (new FundingClient($stub))->ping(new Proto\PingRequest());
    }

    public function testNonPositiveTimeoutAndMissingTargetAreRejected(): void
    {
        $stub = $this->getMockBuilder(Proto\AssetServiceClient::class)->disableOriginalConstructor()->getMock();
        foreach ([0, -1] as $timeout) {
            try {
                new FundingClient($stub, $timeout);
                self::fail('Expected an invalid timeout to be rejected.');
            } catch (\InvalidArgumentException $exception) {
                self::assertStringContainsString('timeout', $exception->getMessage());
            }
        }
        $this->expectException(\InvalidArgumentException::class);
        FundingClient::connect('');
    }

    public function testCloseReleasesTheUnderlyingClient(): void
    {
        $stub = $this->getMockBuilder(Proto\AssetServiceClient::class)->disableOriginalConstructor()->onlyMethods(['close'])->getMock();
        $stub->expects(self::once())->method('close');
        (new FundingClient($stub))->close();
    }
}
