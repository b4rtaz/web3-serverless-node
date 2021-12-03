# Web3 Serverless Node

This is a simple Web3 serverless node. It requires PHP8+.

## ⚡ How to Build

1. Clone this repository:

```
git clone https://github.com/b4rtaz/web3-serverless-node.git
```

2. Install dependencies with [composer](https://getcomposer.org/):

```
composer install
```

3. Set `basePath` in `configs/app.php` (if you deploy this app in root directory than `basePath` should be `/`).

4. Add Ethereum networks in `configs/ethereumNetworks.php`.

5. Add smart contracts in `configs/smartContracts.php` and ABI JSON files in `storage/abi`.

## 🚀 Calling Smart Contract Method

`https://your-server/contracts/{contractName}/{methodName}?arg1=value1&arg2=value2...`

* `contractName` - contract name defined in `configs/smartContracts.php`
* `methodName` - method name defined in contract ABI.

### Example Requests

`GET https://your-server/contracts/weth-bnb-pancake-pair/name`

```json
"Pancake LPs"
```

`GET https://your-server/contracts/weth-bnb-pancake-pair/getReserves`

```json
{
    "_reserve0": "0x00000000000000000000000000000000000000000000051c5243923e4e2c2685",
    "_reserve1": "0x0000000000000000000000000000000000000000000025acbaa5c45d5c0254c5",
    "_blockTimestampLast": "0x0000000000000000000000000000000000000000000000000000000061aa3c22"
}
```

## 🤝 Contributing

Contributions, issues and feature requests are welcome!

## 💡 License

This project is released under the MIT license.