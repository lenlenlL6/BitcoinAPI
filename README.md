# BitcoinAPI
A new plugin like EconomyAPI but with a different mode
# API FUNCTION
- Add Bitcoin
```
$this->bitcoin = $this->getServer()->getPluginManager()->getPlugin("BitcoinAPI");

$this->butcoin->addBitcoin($player, "200"); //You can't use float in amount
```
