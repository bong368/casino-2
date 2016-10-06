<?
require_once('egtCtrl.php');

class burning_hotCtrl extends egtCtrl {

    public function startLogin($request) {
        $this->setSessionIfEmpty('gambles', 0);
        $this->setSessionIfEmpty('state', 'SPIN');
        $this->setSessionIfEmpty('gambleCards', array());

        $balance = $this->getBalance() * 100;

        $json = '{
    "playerName": "igambler1515",
    "balance": '.$balance.',
    "currency": "'.$this->gameParams->curiso.'",
    "languages": ["en","ru"],
    "groups": ["all"],
    "showRtp": false,
    "multigame": true,
    "autoplayLimit": 0,
    "complex": {
        "BHJSlot": [{
            "gameIdentificationNumber": 801,
            "recovery": "norecovery",
            "gameName": "Burning Hot",
            "featured": false,
            "mlmJackpot": true,
            "totalBet": 0,
            "groups": [{
                "name": "all",
                "order": 6
            }]
        }]
    },
    "sessionKey": "'.$this->sessionKey.'",
    "msg": "success",
    "messageId": "'.$this->messageId.'",
    "qName": "app.services.messages.response.LoginResponse",
    "command": "login",
    "eventTimestamp": '.$this->getTimeStamp().'
}';

        $this->out($json);
    }

    public function startSubscribe($request) {
        $state = '';

        $this->slot = new Slot($this->gameParams, 1, 1);
        $this->slot->createCustomReels($this->gameParams->reels[0], $this->gameParams->reelConfig);
        $this->slot->rows = 4;

        if($_SESSION['state'] == 'SPIN') {
            $state = 'idle';
            $winAmount = 0;
            $fsUsed = 0;
            $gamblesUsed = 0;
            $totalFs = 0;
            $reelsLinesScatters = $this->getRandomDisplay().'
            "lines": [],
            "scatters": [],';
        }
        elseif($_SESSION['state'] == 'GAMBLE') {
            $state = 'gamble';
            $winAmount = $_SESSION['lastWin'] * 100;
            $fsUsed = 0;
            $gamblesUsed = 5 - $_SESSION['gambles'] + 1;
            $totalFs = 0;

            $report = unserialize(gzuncompress(base64_decode($_SESSION['report'])));
            $reelsLinesScatters = $_SESSION['reels'].$this->getWinLinesData($report).$this->getScatters($report, $this->gameParams->scatter[0]);
        }

        $json = '{
    "complex": {
        "currentState": {
            "gamblesUsed": '.$gamblesUsed.',
            "previousGambles": ['.implode(',', $_SESSION['gambleCards']).'],
            "bet": 100,
            "numberOfLines": '.count($this->gameParams->winLines).',
            "denomination": 100,
            "state": "'.$state.'",
            "winAmount": '.$winAmount.',
            '.$reelsLinesScatters.'
            "expand": [],
            "gambles": '.$_SESSION['gambles'].',
            "jackpot": false
        }
    },
    "gameIdentificationNumber": '.$this->gameIdentificationNumber.',
    "gameNumber": -1,
    "sessionKey": "'.$this->sessionKey.'",
    "msg": "success",
    "messageId": "'.$this->messageId.'",
    "qName": "app.services.messages.response.GameEventResponse",
    "command": "subscribe",
    "eventTimestamp": '.$this->getTimeStamp().'
}';


        $this->out($json);
    }

    protected function startSpin($request) {
        $_SESSION['state'] = 'SPIN';
        $pick = $request->bet->lines;
        $betPerLine = $request->bet->bet / 100;
        $stake = $pick * $betPerLine;

		$this->checkLastWin();

        $balance = $this->getBalance();
        if($stake > $balance) {
            die();
        }

        $this->slot = new Slot($this->gameParams, $pick, $stake);
        if($this->gameParams->jackpotEnable) {
            $this->slot->createCustomReels($this->gameParams->reels[2], $this->gameParams->reelConfig);
        }
        else {
            $this->slot->createCustomReels($this->gameParams->reels[0], $this->gameParams->reelConfig);
        }

        $spinData = $this->getSpinData();
        $totalWin = $spinData['totalWin'];
        $respin = $spinData['respin'];

        while($this->checkBankPayments($stake * 100, $totalWin * 100) || $respin) {
            $spinData = $this->getSpinData();
            $totalWin = $spinData['totalWin'];
            $respin = $spinData['respin'];
        }

        switch($spinData['report']['type']) {
            case 'SPIN':
                $this->showSpinReport($spinData['report'], $spinData['totalWin']);
                break;
        }

        $_SESSION['lastBet'] = $stake;
        $_SESSION['lastPick'] = $pick;
        $_SESSION['lastStops'] = $spinData['report']['stops'];
    }

    protected function getSpinData() {
        $this->spinPays = array();
        $this->fsPays = array();
        $this->bonusPays = array();

        $respin = false;

        $bonus = array(
            'type' => 'expandWildIfLines',
            'symbol' => 8,
        );

        $report = $this->slot->spin($bonus);

        $report['type'] = 'SPIN';

        $sr1 = $this->slot->getSymbolAnyCount($this->gameParams->scatter[0]);
        $sr2 = $this->slot->getSymbolAnyCount($this->gameParams->scatter[1]);
        $report['scattersReport'] = array();
        $report['scattersReport']['totalWin'] = 0;
        $report['scattersReport']['alias'] = '';

        if(!empty($this->gameParams->scatterMultiple[$this->gameParams->scatter[0]][$sr1['count']])) {
            $report['scattersReport']['offsets'] = $sr1['offsets'];
            $report['scattersReport']['count'] = $sr1['count'];
            $report['scattersReport']['alias'] = $this->gameParams->scatter[0];

            $report['scattersReport']['totalWin'] = $report['bet'] * $this->gameParams->scatterMultiple[$this->gameParams->scatter[0]][$sr1['count']];
            $report['totalWin'] += $report['scattersReport']['totalWin'];
            $report['spinWin'] += $report['scattersReport']['totalWin'];
        }

        if(!empty($this->gameParams->scatterMultiple[$this->gameParams->scatter[1]][$sr2['count']])) {
            $report['scattersReport']['offsets'] = $sr2['offsets'];
            $report['scattersReport']['count'] = $sr2['count'];
            $report['scattersReport']['alias'] = $this->gameParams->scatter[1];

            $report['scattersReport']['totalWin'] = $report['bet'] * $this->gameParams->scatterMultiple[$this->gameParams->scatter[1]][$sr2['count']];
            $report['totalWin'] += $report['scattersReport']['totalWin'];
            $report['spinWin'] += $report['scattersReport']['totalWin'];
        }

        $totalWin = $report['totalWin'];

        return array(
            'totalWin' => $totalWin,
            'report' => $report,
            'respin' => $respin,
        );
    }

    public function showSpinReport($report, $totalWin) {
        if($report['totalWin'] >= $report['bet'] * 35) {
            $this->spinPays[] = array(
                'win' => $report['totalWin'],
                'report' => $report,
            );
        }
        else {
            $this->spinPays[] = array(
                'win' => 0,
                'report' => $report,
            );

        }
        $this->startPay();

        $display = $this->getDisplayByTmp();
        $winLines = $this->getWinLinesData($report);
        $balance = $this->getBalance() * 100;
        $scatters = $this->getScatters($report, $report['scattersReport']['alias']);

        $expandOffsets = array();
        foreach($report['bonusData'] as $b) {
            $expandOffsets = array_merge($expandOffsets, $b['expandOffsets']);
        }
        $expand = $this->getExpand($expandOffsets);

        $state = 'idle';
        $_SESSION['gambles'] = 0;
        if($report['totalWin'] > 0 && $report['totalWin'] < $report['bet'] * 35) {
            $state = 'gamble';
            $_SESSION['gambles'] = 5;
            $_SESSION['report'] = base64_encode(gzcompress(serialize(array(
                'winLines' => $report['winLines'],
                'reels' => $report['reels'],
                'type' => $report['type'],
                'bet' => $report['bet'],
                'betOnLine' => $report['betOnLine'],
                'linesCount' => $report['linesCount'],
                'scattersReport' => $report['scattersReport'],
            )), 9));
            $_SESSION['reels'] = $display;
            $_SESSION['state'] = 'GAMBLE';
        }

        $json = '{
    "complex": {
        '.$display.$winLines.$scatters.$expand.'
        "gambles": '.$_SESSION['gambles'].',
        "freespins": 0,
        "jackpot": false,
        "gameCommand": "bet"
    },
    "state": "'.$state.'",
    "winAmount": '.($report['totalWin']*100).',
    "gameIdentificationNumber": '.$this->gameIdentificationNumber.',
    "gameNumber": 1303752974352,
    "balance": '.$balance.',
    "sessionKey": "'.$this->sessionKey.'",
    "msg": "success",
    "messageId": "'.$this->messageId.'",
    "qName": "app.services.messages.response.GameEventResponse",
    "command": "bet",
    "eventTimestamp": '.$this->getTimeStamp().'
}';

        $_SESSION['lastWin'] = $report['totalWin'];

        $this->out($json);
    }

}