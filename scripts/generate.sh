#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
PROTOC="${PROTOC:-protoc}"
GRPC_PLUGIN="${GRPC_PHP_PLUGIN:-$(command -v grpc_php_plugin || true)}"

command -v "${PROTOC}" >/dev/null 2>&1 || {
    echo "protoc is required" >&2
    exit 1
}
if [[ -z "${GRPC_PLUGIN}" || ! -x "${GRPC_PLUGIN}" ]]; then
    echo "grpc_php_plugin is required; set GRPC_PHP_PLUGIN to its executable path" >&2
    exit 1
fi

mkdir -p "${ROOT_DIR}/src"
"${PROTOC}" \
    --proto_path="${ROOT_DIR}/proto" \
    --php_out="${ROOT_DIR}/src" \
    --grpc_out="${ROOT_DIR}/src" \
    --plugin="protoc-gen-grpc=${GRPC_PLUGIN}" \
    "${ROOT_DIR}/proto/asset_service.proto"
