# BitcoinAPI
A new plugin like EconomyAPI but with a different mode
# API FUNCTION
- Add Bitcoin
```
$this->bitcoin = $this->getServer()->getPluginManager()->getPlugin("BitcoinAPI");

$this->bitcoin->addBitcoin($player, "200"); //You can't use float in amount
```
- Reduce Bitcoin
```
$this->bitcoin = $this->getServer()->getPluginManager()->getPlugin("BitcoinAPI");
$this->bitcoin->reduceBitcoin($player, "200"); //Like Add Bitcoin you can't use float in amount
```
- Get All Bitcoin (Make Top Bitcoin)
```
$this->bitcoin = $this->getServer()->getPluginManager()->getPlugin("BitcoinAPI");
$this->bitcoin->getAllBitcoin(); //You can make top bitcoin with this
```
