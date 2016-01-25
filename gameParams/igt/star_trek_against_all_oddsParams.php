

<?

class star_trek_against_all_oddsParams extends Params {
    public $reels = array(
        array(
            array(9,5,2,8,2,51,3,4,2,51,4,2,5,2,1,2,5,2,4,2,4,2,5,4,51,5,2,4,4,2,4,4,2,3,5,8,51,2,5,51,4,7,51,4,2,51,4,3,5,51,7,2,5,1,4,3,9,4,2,9,8,1,51,4,5,51,6,4,51,5,4,51,5,3,51,5,7,2,1,5,51,4,2,7,51,2,5,2,9,8,2,51,4,5,51,7,1,4,2,4,5,4,4,7,2,5,51,4,5,5,6,5,51,2,5,3,9,2,4,1,8,3,51,8,5,5,2,51,6,3,5,51,2,5,2,6,2,1,4,51,2,4,5,4,2,5,2,51,5,4,51,2,4,2,1,2,),
            array(8,7,8,4,8,7,4,7,5,7,8,6,7,2,51,8,3,6,6,5,4,4,5,2,6,7,6,1,4,51,2,6,8,6,51,6,7,6,8,4,51,6,7,6,9,7,6,2,6,7,3,51,7,6,7,6,2,6,2,6,7,51,3,9,2,51,6,4,2,6,4,51,7,6,6,2,51,7,4,3,9,7,6,51,4,7,6,4,51,7,1,4,6,7,4,6,51,2,7,6,7,51,4,6,7,4,51,6,4,7,51,6,4,4,51,6,4,4,2,4,5,51,4,6,4,7,4,51,6,1,7,9,6,4,7,4,6,51,6,4,6,7,51,6,4,7,51,3,6,4,3,4,3,4,51,7,7,6,9,4,3,6,51,7,3,5,5,0,0,0,0,4,7,4,7,6,7,51,8,7,7,9,7,5,7,7,51,4,7,1,5,7,),
            array(3,8,51,7,8,7,3,3,51,8,3,8,7,4,1,7,3,8,1,7,51,8,7,3,8,51,7,4,8,5,51,8,4,8,7,51,6,3,5,8,51,3,6,3,7,1,51,7,1,8,8,3,3,51,7,5,7,5,5,3,9,7,6,7,51,7,6,7,4,8,51,7,8,3,2,8,7,8,51,6,3,7,3,7,3,7,9,8,3,8,1,4,8,3,7,8,3,8,3,51,1,8,3,8,3,8,7,2,0,0,0,0,0,8,3,8,3,7,1,3,8,3,8,51,7,3,7,8,3,8,51,3,1,3,1,8,7,3,1,3,8,8,5,1,3,51,7,7,7,9,3,8,51,7,2,2,8,8,51,7,2,7,3,7,51,8,3,1,8,51,8,3,7,3,7,3,9,8,3,8,3,3,7,3,7,9,7,3,1,8,7,1,7,1,7,),
            array(4,4,4,1,7,9,4,3,6,8,7,5,4,4,3,3,6,6,4,1,3,4,3,7,2,5,3,51,4,7,3,7,3,5,3,4,6,51,3,4,3,7,3,7,3,7,5,2,6,7,6,7,6,7,6,7,5,6,9,6,3,6,5,4,6,4,3,6,4,6,5,4,3,4,5,4,5,4,5,3,8,4,7,51,6,4,3,51,6,4,4,9,1,3,3,4,51,3,4,4,51,3,6,2,7,0,0,0,0,5,6,3,3,4,8,6,3,51,5,6,8,51,6,5,6,2,51,5,5,6,7,51,8,5,2,4,9,6,6,6,4,2,8,9,5,5,5,4,51,2,3,6,3,6,3,6,3,51,5,6,6,6,8,8,1,6,6,51,7,7,6,6,3,9,6,2,7,7,6,6,7,4,7,4,),
            array(2,5,8,3,8,5,5,1,5,4,1,9,6,5,9,7,3,6,3,51,5,7,2,4,51,8,1,6,8,5,6,2,8,7,6,8,51,6,2,5,5,8,5,2,5,6,8,6,8,7,6,5,5,8,8,5,51,8,6,5,8,8,7,5,6,8,5,9,6,8,1,5,8,7,8,6,5,5,8,1,6,5,5,2,5,8,5,51,8,9,5,6,8,6,5,51,8,6,8,4,6,5,2,9,6,8,6,1,5,51,6,8,6,5,9,2,6,6,2,6,1,9,8,6,6,5,6,4,51,3,6,5,5,6,8,5,51,6,8,5,4,8,51,4,8,9,5,2,6,8,4,51,8,5,8,8,1,8,5,5,8,6,8,8,),
        ),
    );

    public $reelConfig = array(3,4,5,4,3);

    public $symbols = array(
        'b01' => array(51),
        's01' => array(1),
        's02' => array(2),
        's03' => array(3),
        's04' => array(4),
        's05' => array(5),
        's06' => array(6),
        's07' => array(7),
        's08' => array(8),
        's09' => array(9),
        'w01' => array(0),
    );
    // Вайлд
    public $wild = array(0);
    // Скаттер
    public $scatter = array(99);
    // Умножение ставки, когда выпали скаттеры
    public $scatterMultiple = array(
        '3' => 3,
    );

    public $winLines = array(

    );

    public $winLineType = 'waysLeftRight';
    public $minWinCount = 3;

    public $payOnlyHighter = true;
    // настройка ставок
    public $currency = '$';
    public $curiso = 'USD';
    public $default_coinvalue = 0.05;
    public $defaultCoinsCount = 30;

    public $denominations = array(1,2,3,5,10,20,30,50,100,200,300,500,1000,2000,3000,5000,10000,20000,30000,50000,100000);
    public $lang = 'en';
    public $flash_scale_exactfit = 1;

    public $winPay = array(
        array('symbol'=> 's01', 'count'=> 5, 'multiplier'=> 1000),
        array('symbol'=> 's01', 'count'=> 4, 'multiplier'=> 150),
        array('symbol'=> 's01', 'count'=> 3, 'multiplier'=> 50),
        array('symbol'=> 's02', 'count'=> 5, 'multiplier'=> 500),
        array('symbol'=> 's02', 'count'=> 4, 'multiplier'=> 75),
        array('symbol'=> 's02', 'count'=> 3, 'multiplier'=> 25),
        array('symbol'=> 's03', 'count'=> 5, 'multiplier'=> 300),
        array('symbol'=> 's03', 'count'=> 4, 'multiplier'=> 50),
        array('symbol'=> 's03', 'count'=> 3, 'multiplier'=> 20),
        array('symbol'=> 's04', 'count'=> 5, 'multiplier'=> 125),
        array('symbol'=> 's04', 'count'=> 4, 'multiplier'=> 30),
        array('symbol'=> 's04', 'count'=> 3, 'multiplier'=> 15),
        array('symbol'=> 's05', 'count'=> 5, 'multiplier'=> 100),
        array('symbol'=> 's05', 'count'=> 4, 'multiplier'=> 25),
        array('symbol'=> 's05', 'count'=> 3, 'multiplier'=> 10),
        array('symbol'=> 's06', 'count'=> 5, 'multiplier'=> 100),
        array('symbol'=> 's06', 'count'=> 4, 'multiplier'=> 20),
        array('symbol'=> 's06', 'count'=> 3, 'multiplier'=> 5),
        array('symbol'=> 's07', 'count'=> 5, 'multiplier'=> 100),
        array('symbol'=> 's07', 'count'=> 4, 'multiplier'=> 20),
        array('symbol'=> 's07', 'count'=> 3, 'multiplier'=> 5),
        array('symbol'=> 's08', 'count'=> 5, 'multiplier'=> 100),
        array('symbol'=> 's08', 'count'=> 4, 'multiplier'=> 20),
        array('symbol'=> 's08', 'count'=> 3, 'multiplier'=> 5),
    );
}