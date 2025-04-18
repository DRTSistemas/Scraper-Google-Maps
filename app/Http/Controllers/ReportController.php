<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use App\Transaction;
use App\Donation;
use App\Bonus;
use App\UserPlan;
use App\User;
use App\Request as ModelRequest;
use Auth;

class ReportController extends BaseController
{

    public function searchs()
    {

        // Obtém o usuário logado
        $user = Auth::user();

        // Todas as requests do usuário (sem filtro de tempo)
        $countRequests = ModelRequest::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->count();

        // Requests do usuário nos últimos 30 dias
        $last30DaysRequests = ModelRequest::where('user_id', $user->id)
                            ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('reports.searchs', [
            'from' => Carbon::now()->subDays(30)->toDateString(),
            'to' => Carbon::now()->toDateString(),
            'countRequests' => $countRequests,
            'countLastRequests' => $last30DaysRequests->count(),
            'requests' => $last30DaysRequests,
            'config' => $this->config()
        ]);
    }

    public function donationsReceived()
    {
        $from = isset($_GET['from']) ? $_GET['from'] : '01'.date('/m/Y');
        $to   = isset($_GET['to']) ? $_GET['to'] : date('d/m/Y');

        $formatFrom = $this->dateEmMysql($from);
        $formatTo   = $this->dateEmMysql($to);

        if($this->checkAdmin()) {
            $receive = Transaction::select('transactions.*')
                ->join('users', 'transactions.to_user_id', '=', 'users.id')
                ->where([
                    ['transactions.status', '<>', 2],
                    ['users.level', 1],
                    ['transactions.updated_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                    ['transactions.updated_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                    ['transactions.is_20', 0]
                ])
                ->orderBy('updated_at', 'desc');

            $receiveTotal = Transaction::select('transactions.*')
                ->join('users', 'transactions.to_user_id', '=', 'users.id')
                ->where([
                    ['transactions.status', '<>', 2],
                    ['users.level', 1],
                    ['transactions.is_20', 0]
                ])
                ->orderBy('updated_at', 'desc');
        } else {
            $receive = Transaction::where([
                ['to_user_id', Auth::id()],
                ['status', '<>', 2],
                ['updated_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                ['updated_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                ['transactions.is_20', 0],
                ['hash', '<>', '2f1729abc064a22ba8c4fa4f862529cea440b8e326b4db751cc3c88a082c294b'],
                ['hash', '<>', 'a35404de595e556737730cd596621858be425157dd4d6f8dd6aad3e0de103321'],
                ['hash', '<>', '82B6E19189719BAD90C733E323FE2D12238C35695FFC759D5AB5A3744F873477'],
                ['hash', '<>', 'DF585B4005B16B92E86D8933AD2B7ED57C265A3BB40DFEF08007C12E991B3018'],
                ['hash', '<>', '27FC4812A9715AFE4E94A8BDB5C9D233D2D392FA509239B87EAA21CD9D55DBD8'],
                ['hash', '<>', 'D0A3C9CABA2314E442A09241A7FFBE704C93079587E54BDE01BEE36AAFDEA964'],
                ['hash', '<>', 'DC4ECE3A2F720A9A8F53D6E903D8523F834403494404B71263B1CBAA2B32FED6'],
                ['hash', '<>', '736ACFD541AB3221191520417867FE0645209F93690FBC7467271C74C9D64D13'],
                ['hash', '<>', '469FFCE6705FB934FA867C7D7992C08BAA1E09BD51A70D8149ED587E3309C61C'],
                ['hash', '<>', '96C3386DFA9DBECF944F6DFFE8ADA6E6FEB4F0F77BB306E02CFD4ECC93412454'],
                ['hash', '<>', '9C29249261317D751221D7BE81A81032DC367D5146D47A915BDDB4B9ADB92C99'],
                ['hash', '<>', 'B08923296FC093F385280ED87B1EA9C3102A0A047D7A32DBB9E6C0F8F969307E'],
                ['hash', '<>', '8AA914243E491389F2E38FC2A0FF7DAB12A4C94D12AB8517C29F3190FEC316F0'],
                ['hash', '<>', 'DC79272B8A3DED5E21C385A129DE7991E746777DA4AAEA3CFD1F183220832B9F'],
                ['hash', '<>', '23614DADC47905F71D7C4E5318885E182E77E793805F82093322D184DECBF8FA'],
                ['hash', '<>', '0AC401C069EA5BFA036C4BDB0A434E538ADFC43A805CA6A8CA66FF2DBF645C0B'],
                ['hash', '<>', 'B195A0A395291530107759F0CD1064C3782B4321D31268D3A0F260E10ED67300'],
                ['hash', '<>', '8BE3A71AB271E02C04E2A6518C036575459D490D8BE81BD66099EE8852905E7A'],
                ['hash', '<>', 'AD77C49C5767EEDC8AC7E80BF694B9FA86D83718895CCB5DBB88F814FE2FE2E1'],
                ['hash', '<>', '2C540FB04CA5AC6D61AEEE4036EC0184B057207BE35E20A078FAD329360EC353'],
                ['hash', '<>', '14B9D8AD9FD959E740940ED31018CCEA36DF77ED32F0DDCA790CEE5718CD5187'],
                ['hash', '<>', 'CF4E5801B344B530BE0AA57F6A9E3082D2C98062F2D7C571192980AAEB708B0A'],
                ['hash', '<>', '29BB78CED13EFD46F32FF7D72ADFF30A453297A86DE2641D5C61FB50740E251D'],
                ['hash', '<>', '9157391264127F522CA9AECC4E5B29452EFB747EE92668E8D0C21B2D98F057EC'],
                ['hash', '<>', 'EAFFAB833AB7C33AABA3A9B913CD2BE47381049EF7CD7D3B9AD55A9F79E27C5D'],
                ['hash', '<>', '5CE6BB3729E8D8436ABA6362124FA62C358A4E1C5B60EF4348D59E176052475A'],
                ['hash', '<>', '7C2E7F803276897E4A9343AA0EDF72C3551F72BAD29D0FB5EA46C341D02C1B35'],
                ['hash', '<>', '7189E07FFB83A6EB006F1EB8F2A3816D785E843D537B7F1E488291755C9D460C'],
                ['hash', '<>', '75CF36DBFB07D51E4702AB332B5B04F6E4C323010A3DCBE2D407B492475C0DF5'],
                ['hash', '<>', 'FF80DF263E26CD1C96880A9317A5F32491E2FADD6AA01000A04188EA9F4546CA'],
                ['hash', '<>', '5AC7AEBC46C88888CC0C1EA5833F83734AF73D88DA3B5464FA42F210BF0283A2'],
                ['hash', '<>', '001FC705F05AA5FEE790146E256F501DDEC4E370E41D0D994F7EE84AE6E148E6'],
                ['hash', '<>', 'A70DD904B2B2BC45EEB03B20532DA1BCED2C8532A5A93DAF99FCBF7325D04FF6'],
                ['hash', '<>', 'F210688D811642784111CED8D47F2729D51C78FB52317F6F345EFF0F7485AD5F'],
                ['hash', '<>', '3620AAF88F47FF37A1B90225E37DA942104AE34E75C79AA97DE31D13EB2A830E'],
                ['hash', '<>', '9D29EFEBA7880EB53F4A640B370B96DA7EEDF2651E4E950C411E573212DBD0DF'],
                ['hash', '<>', '5CAA9E9E53757E22773D57BF42BFFDDD130625567468EE217BC8F960860C5149'],
                ['hash', '<>', 'C26C7E732221C682FAF2CF761BE2B0F6DD58703BABE16D55956C0D0810F4C19E'],
                ['hash', '<>', '6720CF69CBD1076B5A0F5A056B575B61EEDF66B34234C327C4B6F8EBC75B15C6'],
                ['hash', '<>', '6DC4643C1D73B5B320DFBB5F629ABA9B5D661C3951AFE6C8D4F7DCB2FBFAB1E8'],
            ])
            ->orderBy('updated_at', 'desc');

            $receiveTotal = Transaction::where([
                ['to_user_id', Auth::id()],
                ['status', '<>', 2],
                ['transactions.is_20', 0],
                ['hash', '<>', '2f1729abc064a22ba8c4fa4f862529cea440b8e326b4db751cc3c88a082c294b'],
                ['hash', '<>', 'a35404de595e556737730cd596621858be425157dd4d6f8dd6aad3e0de103321'],
                ['hash', '<>', '82B6E19189719BAD90C733E323FE2D12238C35695FFC759D5AB5A3744F873477'],
                ['hash', '<>', 'DF585B4005B16B92E86D8933AD2B7ED57C265A3BB40DFEF08007C12E991B3018'],
                ['hash', '<>', '27FC4812A9715AFE4E94A8BDB5C9D233D2D392FA509239B87EAA21CD9D55DBD8'],
                ['hash', '<>', 'D0A3C9CABA2314E442A09241A7FFBE704C93079587E54BDE01BEE36AAFDEA964'],
                ['hash', '<>', 'DC4ECE3A2F720A9A8F53D6E903D8523F834403494404B71263B1CBAA2B32FED6'],
                ['hash', '<>', '736ACFD541AB3221191520417867FE0645209F93690FBC7467271C74C9D64D13'],
                ['hash', '<>', '469FFCE6705FB934FA867C7D7992C08BAA1E09BD51A70D8149ED587E3309C61C'],
                ['hash', '<>', '96C3386DFA9DBECF944F6DFFE8ADA6E6FEB4F0F77BB306E02CFD4ECC93412454'],
                ['hash', '<>', '9C29249261317D751221D7BE81A81032DC367D5146D47A915BDDB4B9ADB92C99'],
                ['hash', '<>', 'B08923296FC093F385280ED87B1EA9C3102A0A047D7A32DBB9E6C0F8F969307E'],
                ['hash', '<>', '8AA914243E491389F2E38FC2A0FF7DAB12A4C94D12AB8517C29F3190FEC316F0'],
                ['hash', '<>', 'DC79272B8A3DED5E21C385A129DE7991E746777DA4AAEA3CFD1F183220832B9F'],
                ['hash', '<>', '23614DADC47905F71D7C4E5318885E182E77E793805F82093322D184DECBF8FA'],
                ['hash', '<>', '0AC401C069EA5BFA036C4BDB0A434E538ADFC43A805CA6A8CA66FF2DBF645C0B'],
                ['hash', '<>', 'B195A0A395291530107759F0CD1064C3782B4321D31268D3A0F260E10ED67300'],
                ['hash', '<>', '8BE3A71AB271E02C04E2A6518C036575459D490D8BE81BD66099EE8852905E7A'],
                ['hash', '<>', 'AD77C49C5767EEDC8AC7E80BF694B9FA86D83718895CCB5DBB88F814FE2FE2E1'],
                ['hash', '<>', '2C540FB04CA5AC6D61AEEE4036EC0184B057207BE35E20A078FAD329360EC353'],
                ['hash', '<>', '14B9D8AD9FD959E740940ED31018CCEA36DF77ED32F0DDCA790CEE5718CD5187'],
                ['hash', '<>', 'CF4E5801B344B530BE0AA57F6A9E3082D2C98062F2D7C571192980AAEB708B0A'],
                ['hash', '<>', '29BB78CED13EFD46F32FF7D72ADFF30A453297A86DE2641D5C61FB50740E251D'],
                ['hash', '<>', '9157391264127F522CA9AECC4E5B29452EFB747EE92668E8D0C21B2D98F057EC'],
                ['hash', '<>', 'EAFFAB833AB7C33AABA3A9B913CD2BE47381049EF7CD7D3B9AD55A9F79E27C5D'],
                ['hash', '<>', '5CE6BB3729E8D8436ABA6362124FA62C358A4E1C5B60EF4348D59E176052475A'],
                ['hash', '<>', '7C2E7F803276897E4A9343AA0EDF72C3551F72BAD29D0FB5EA46C341D02C1B35'],
                ['hash', '<>', '7189E07FFB83A6EB006F1EB8F2A3816D785E843D537B7F1E488291755C9D460C'],
                ['hash', '<>', '75CF36DBFB07D51E4702AB332B5B04F6E4C323010A3DCBE2D407B492475C0DF5'],
                ['hash', '<>', 'FF80DF263E26CD1C96880A9317A5F32491E2FADD6AA01000A04188EA9F4546CA'],
                ['hash', '<>', '5AC7AEBC46C88888CC0C1EA5833F83734AF73D88DA3B5464FA42F210BF0283A2'],
                ['hash', '<>', '001FC705F05AA5FEE790146E256F501DDEC4E370E41D0D994F7EE84AE6E148E6'],
                ['hash', '<>', 'A70DD904B2B2BC45EEB03B20532DA1BCED2C8532A5A93DAF99FCBF7325D04FF6'],
                ['hash', '<>', 'F210688D811642784111CED8D47F2729D51C78FB52317F6F345EFF0F7485AD5F'],
                ['hash', '<>', '3620AAF88F47FF37A1B90225E37DA942104AE34E75C79AA97DE31D13EB2A830E'],
                ['hash', '<>', '9D29EFEBA7880EB53F4A640B370B96DA7EEDF2651E4E950C411E573212DBD0DF'],
                ['hash', '<>', '5CAA9E9E53757E22773D57BF42BFFDDD130625567468EE217BC8F960860C5149'],
                ['hash', '<>', 'C26C7E732221C682FAF2CF761BE2B0F6DD58703BABE16D55956C0D0810F4C19E'],
                ['hash', '<>', '6720CF69CBD1076B5A0F5A056B575B61EEDF66B34234C327C4B6F8EBC75B15C6'],
                ['hash', '<>', '6DC4643C1D73B5B320DFBB5F629ABA9B5D661C3951AFE6C8D4F7DCB2FBFAB1E8'],
            ])
            ->orderBy('updated_at', 'desc');
        }

        $donationsPerDay = [];
        $totalConfirmed = 0;
        $totalPending   = 0;
        $total          = 0;

        foreach($receive->get() as $r) {
            if(empty($r->user_plan_id) && $r->status != 1) {

            } else {
                if($r->status == 1) {
                    $totalConfirmed += $r->value;
                }

                if($r->status == 0 && !is_null($r->user_plan_id)) {
                    $totalPending += $r->value;
                }

                $date = date('Y-m-d', strtotime($r->updated_at));

                if(array_key_exists($date, $donationsPerDay)) {
                    $donationsPerDay[$date] += $r->value;
                } else {
                    $donationsPerDay[$date] = $r->value;
                }
            }
        }

        foreach($receiveTotal->get() as $r) {
            if(empty($r->user_plan_id) && $r->status != 1) {

            } else {
                $total += $r->value;
            }
        }


        $donationsPerDay = array_reverse($donationsPerDay);

        return view('reports.donations.received' , [
            'receives'       => $receive->get(),
            'totalConfirmed' => $totalConfirmed,
            'totalPending'   => $totalPending,
            'total'          => $total,
            'from'           => $from,
            'to'             => $to,
            'donationsPerDay' => $donationsPerDay,
            'config'         => $this->config()
        ]);
    }

    public function donationsMade()
    {
        $from = isset($_GET['from']) ? $_GET['from'] : '01'.date('/m/Y');
        $to   = isset($_GET['to']) ? $_GET['to'] : date('d/m/Y');

        $formatFrom = $this->dateEmMysql($from);
        $formatTo   = $this->dateEmMysql($to);

        if($this->checkAdmin()) {
            $donate = Transaction::select('transactions.*')->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
            ->where([
                ['transactions.status', '<>', 2],
                ['transactions.created_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                ['transactions.created_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                ['transactions.is_20', 0],
            ])
            ->whereIn('user_plans.user_id', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,485,486,487,488,489,490,491,492,493,494,3145,3146,3147,3148,3149,3150,3151,3152,3153,3154,3155,3156,3157,3158,3159,3160,3243,3244])
            ->where([
                ['transactions.status', '<>', 2],
                ['transactions.updated_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                ['transactions.updated_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                ['transactions.is_20', 0],
            ])
            ->orderBy('updated_at', 'desc');

            $donateTotal = Transaction::select('transactions.*')->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
            ->where([
                ['transactions.status', '<>', 2],
                ['transactions.is_20', 0],
            ])
            ->whereIn('user_plans.user_id', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,485,486,487,488,489,490,491,492,493,494,3145,3146,3147,3148,3149,3150,3151,3152,3153,3154,3155,3156,3157,3158,3159,3160,3243,3244])
            ->where([
                ['transactions.status', '<>', 2],
            ])
            ->orderBy('updated_at', 'desc');

        } else {
            $donate = Transaction::select('transactions.*')->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
            ->where([
                ['user_plans.user_id', Auth::id()],
                ['transactions.status', '<>', 2],
                ['transactions.updated_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                ['transactions.updated_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                ['transactions.is_20', 0],
            ])->orderBy('updated_at', 'desc');

            $donateTotal = Transaction::select('transactions.*')->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
            ->where([
                ['user_plans.user_id', Auth::id()],
                ['transactions.status', '<>', 2],
                ['transactions.is_20', 0],
            ])->orderBy('updated_at', 'desc');
        }

        $donationsPerDay = [];
        $totalConfirmed = 0;
        $totalPending   = 0;
        $total          = 0;

        foreach($donate->get() as $d) {

            if($d->status == 1) {
                $totalConfirmed += $d->value;
            }

            if($d->status == 0 && !is_null($d->user_plan_id)) {
                $totalPending += $d->value;
            }

            $date = date('Y-m-d', strtotime($d->updated_at));

            if(array_key_exists($date, $donationsPerDay)) {
                $donationsPerDay[$date] += $d->value;
            } else {
                $donationsPerDay[$date] = $d->value;
            }
        }

        foreach($donateTotal->get() as $d) {
            $total += $d->value;
        }

        $donationsPerDay = array_reverse($donationsPerDay);

        return view('reports.donations.made' , [
            'donations'      =>  $donate->get(),
            'totalConfirmed' =>  $totalConfirmed,
            'totalPending'   =>  $totalPending,
            'total'          =>  $total,
            'from'           => $from,
            'to'             => $to,
            'donationsPerDay' => $donationsPerDay,
            'config'         =>  $this->config()
        ]);
    }

    public function donationsUsers()
    {

        if(!$this->checkAdmin()) {
            return redirect()->route('home.index');
        }

        $from = isset($_GET['from']) ? $_GET['from'] : '01'.date('/m/Y');
        $to   = isset($_GET['to']) ? $_GET['to'] : date('d/m/Y');

        $formatFrom = $this->dateEmMysql($from);
        $formatTo   = $this->dateEmMysql($to);

        $donate = Transaction::select('transactions.*')
                    ->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
                    ->where([
                        ['transactions.status', '<>', 2],
                        ['transactions.updated_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                        ['transactions.updated_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                    ])
                    ->whereNotIn('user_plans.user_id', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,485,486,487,488,489,490,491,492,493,494,3145,3146,3147,3148,3149,3150,3151,3152,3153,3154,3155,3156,3157,3158,3159,3160])
                    ->orderBy('updated_at', 'desc');

        $donateTotal = Transaction::select('transactions.*')
                    ->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
                    ->where([
                        ['transactions.status', '<>', 2],
                        ['transactions.updated_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                        ['transactions.updated_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                    ])
                    ->whereNotIn('user_plans.user_id', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,485,486,487,488,489,490,491,492,493,494,3145,3146,3147,3148,3149,3150,3151,3152,3153,3154,3155,3156,3157,3158,3159,3160])
                    ->orderBy('updated_at', 'desc');

        $donationsPerDay = [];
        $totalConfirmed = 0;
        $totalPending   = 0;
        $total          = 0;

        foreach($donate->get() as $d) {
            if($d->status == 1) {
                $totalConfirmed += $d->value;
            }

            if($d->status == 0 && !is_null($d->user_plan_id)) {
                $totalPending += $d->value;
            }

            $date = date('Y-m-d', strtotime($d->updated_at));

            if(array_key_exists($date, $donationsPerDay)) {
                $donationsPerDay[$date] += $d->value;
            } else {
                $donationsPerDay[$date] = $d->value;
            }
        }

        foreach($donateTotal->get() as $d) {
            $total += $d->value;
        }

        $donationsPerDay = array_reverse($donationsPerDay);

        return view('reports.donations.users' , [
            'donations'      =>  $donate->paginate(15),
            'totalConfirmed' =>  $totalConfirmed,
            'totalPending'   =>  $totalPending,
            'total'          =>  $total,
            'from'           => $from,
            'to'             => $to,
            'donationsPerDay' => $donationsPerDay,
            'config'         =>  $this->config()
        ]);
    }

    public function donationsInline()
    {

        if(!$this->checkAdmin()) {
            return redirect()->route('home.index');
        }

        $donate = Transaction::select('transactions.*')
                    ->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
                    //->whereNotBetween('user_plans.user_id', [1, 21])
                    ->where([
                        ['transactions.status', 0]
                    ])->orderBy('updated_at', 'desc');

        $donateTotal = Transaction::select('transactions.*')
                    ->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
                    //->whereNotBetween('user_plans.user_id', [1, 21])
                    ->where([
                        ['transactions.status', 0]
                    ])->orderBy('updated_at', 'desc');


        $totalPlans  = 0;
        $plansValues = 0;

        foreach($donate->get() as $d) {
            if(!empty($d->donation()->userPlan())) {
                $plansValues += $d->donation()->userPlan()->plan()->plan_value;
                $totalPlans += 1;
            }
        }

        return view('reports.donations.inline' , [
            'donations'      => $donate->get(),
            'plansValues'    => $plansValues,
            'totalPlans'     => $totalPlans,
            'total'          => $donateTotal->sum('value'),
            'config'         => $this->config()
        ]);
    }

    public function donationsProcessed()
    {

        if(!$this->checkAdmin()) {
            return redirect()->route('home.index');
        }

        $donate = Donation::select('donations.*')
                    //->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
                    //->whereNotBetween('user_plans.user_id', [1, 21])
                    ->where([
                        ['donations.status', 0]
                    ])->orderBy('updated_at', 'desc');

        $totalConfirmed = 0;
        $totalPending   = 0;
        $total          = 0;

        foreach($donate->get() as $d) {
            if($d->status == 1) {
                $totalConfirmed += $d->total;
            }

            if($d->status == 0 && !is_null($d->user_plan_id)) {
                $totalPending += $d->total;
            }

            $total += $d->total;
        }

        return view('reports.donations.processed' , [
            'donations'      =>  $donate->get(),
            'totalConfirmed' =>  $totalConfirmed,
            'totalPending'   =>  $totalPending,
            'total'          =>  $total,
            'config'         =>  $this->config()
        ]);
    }

    public function bonusDirect()
    {
        if($this->checkAdmin()) {
            return redirect()->route('admin.index');
        }

        $direct = Bonus::select('bonuses.*')
            ->join('users', 'bonuses.user_id', '=', 'users.id')
            ->join('transactions', 'bonuses.transaction_id', '=', 'transactions.id')
            ->join('donations', 'transactions.donation_id', '=', 'donations.id')
            ->where([
                ['transactions.to_user_id', '=', 'users.indication_id'],
                ['donations.bonus', 1]
            ])
            ->orderBy('id', 'desc')->paginate(15);

        return view('reports.bonus.direct' , [
            'directs'        =>  $direct,
            'totalConfirmed' =>  $direct->where('status', 2)->sum('value'),
            'totalPending'   =>  $direct->where('status', 1)->sum('value'),
            'config'         => $this->config()
        ]);
    }

    public function bonusIndirect()
    {
        $indirect = Bonus::select('bonuses.*')
            ->join('users', 'bonuses.user_id', '=', 'users.id')
            ->join('transactions', 'bonuses.transaction_id', '=', 'transactions.id')
            ->join('donations', 'transactions.donation_id', '=', 'donations.id')
            ->where([
                ['transactions.to_user_id', '!=', 'users.indication_id'],
                ['donations.bonus', 1]
            ])
            ->orderBy('id', 'desc')->paginate(15);

        return view('reports.bonus.indirect' , [
            'indirects'      =>  $indirect,
            'totalConfirmed' =>  $indirect->where('status', 2)->sum('value'),
            'totalPending'   =>  $indirect->where('status', 1)->sum('value'),
            'config'         => $this->config()
        ]);
    }

    public function pendingPlans()
    {

        if(!$this->checkAdmin()) {
            return redirect()->route('home.index');
        }

        $plansValues = 0;
        $donationsPerDay = [];
        $byValue     = [];

        $donations = UserPlan::select('user_plans.*')
                    ->join('users', 'user_plans.user_id', '=', 'users.id')
                    ->where([
                        ['user_plans.movimentation', 0],
                        ['user_plans.status', 1],
                        ['users.level', 0]
                    ])->orderBy('id', 'desc');

        foreach ($donations->get() as $value) {
            $plansValues += $value->plan()->plan_value;

            $date = date('Y-m-d', strtotime($value->updated_at));

            if(array_key_exists($date, $donationsPerDay)) {
                $donationsPerDay[$date] += $value->plan()->plan_value;
            } else {
                $donationsPerDay[$date] = $value->plan()->plan_value;
            }

            $key = intval($value->plan()->plan_value);
            if(array_key_exists($key, $byValue)) {
                $byValue[$key] += $value->plan()->plan_value;
            } else {
                $byValue[$key] = $value->plan()->plan_value;
            }
        }

        return view('reports.plans.pending' , [
            'donations'       => $donations->get(),
            'totalPlans'      => $donations->get()->count(),
            'plansValues'     => $plansValues,
            'amountDonations' => (30 / 100) * $plansValues,
            'donationsPerDay' => $donationsPerDay,
            'byValue'         => $byValue,
            'config'          => $this->config()
        ]);
    }

    public function completedPlans()
    {

        if(!$this->checkAdmin()) {
            return redirect()->route('home.index');
        }

        $from = isset($_GET['from']) ? $_GET['from'] : '01'.date('/m/Y');
        $to   = isset($_GET['to']) ? $_GET['to'] : date('d/m/Y');

        $formatFrom = $this->dateEmMysql($from);
        $formatTo   = $this->dateEmMysql($to);

        $plansValues = 0;
        $donationsPerDay = [];
        $byValue     = [];

        $donations = UserPlan::select('user_plans.*')
                    ->join('users', 'user_plans.user_id', '=', 'users.id')
                    ->where([
                        ['user_plans.status', 3],
                        ['users.level', 0],
                        ['user_plans.updated_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                        ['user_plans.updated_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                    ])->orderBy('id', 'desc');

        $donationsTotal = UserPlan::select('user_plans.*')
                    ->join('users', 'user_plans.user_id', '=', 'users.id')
                    ->where([
                        ['user_plans.status', 3],
                        ['users.level', 0],
                    ])->orderBy('id', 'desc');

        foreach ($donations->get() as $value) {
            $plansValues += $value->plan()->plan_value;

            $date = date('Y-m-d', strtotime($value->updated_at));

            if(array_key_exists($date, $donationsPerDay)) {
                $donationsPerDay[$date] += $value->plan()->plan_value;
            } else {
                $donationsPerDay[$date] = $value->plan()->plan_value;
            }

            $key = intval($value->plan()->plan_value);
            if(array_key_exists($key, $byValue)) {
                $byValue[$key] += $value->plan()->plan_value;
            } else {
                $byValue[$key] = $value->plan()->plan_value;
            }
        }

        return view('reports.plans.completed' , [
            'donations'   => $donations->get(),
            'plansValues' => $plansValues,
            'donationsPerDay' => $donationsPerDay,
            'byValue'     => $byValue,
            'from'        => $from,
            'to'          => $to,
            'total'       => $donations->get()->count(),
            'totalAll'    => $donationsTotal->get()->count(),
            'config'      => $this->config()
        ]);
    }

    public function donationsFuture(Request $request)
    {

        if(!$this->checkAdmin()) {
            return redirect()->route('home.index');
        }

        $config = $this->config();

        $from = isset($_GET['from']) ? $_GET['from'] : date('d/m/Y');
        $to   = isset($_GET['to']) ? $_GET['to'] : date('d/m/Y');

        $formatFrom = $this->dateEmMysql($from);
        $formatTo   = $this->dateEmMysql($to);

        $donations = Donation::where([
            ['status', '=', 0],
            ['user_plan_id', '<>', null],
            ['created_at', '>=', Carbon::parse($formatFrom)->subDays($config['max_payment_days'])->toDateString() . ' 00:00:00'],
            ['created_at', '<=', Carbon::parse($formatTo)->subDays($config['max_payment_days'])->toDateString() . ' 23:59:00'],
        ])->orderBy('created_at','DESC')->get();

        $donationsPerDay = [];
        $byValue = [];

        foreach ($donations as $value) {
            $date = date('Y-m-d', strtotime($value->created_at));

            if(array_key_exists($date, $donationsPerDay)) {
                $donationsPerDay[$date] += $value->total;
            } else {
                $donationsPerDay[$date] = $value->total;
            }

            $key = intval($value->userPlan()->plan()->plan_value);
            if(array_key_exists($key, $byValue)) {
                $byValue[$key] += $value->total;
            } else {
                $byValue[$key] = $value->total;
            }
        }

        $donationsPerDay = array_reverse($donationsPerDay);

        return view('reports.donations.future', [
            'donations' => $donations,
            'donationsPerDay' => $donationsPerDay,
            'byValue' => $byValue,
            'from'      => $from,
            'to'        => $to
        ]);
    }

    public static function dateEmMysql($dateSql){
        $ano= substr($dateSql, 6);
        $mes= substr($dateSql, 3,-5);
        $dia= substr($dateSql, 0,-8);
        return $ano."-".$mes."-".$dia;
    }

    /* Donations Made e Received 2.0 */
    public function donationsReceived_20()
    {
        $from = isset($_GET['from']) ? $_GET['from'] : '01'.date('/m/Y');
        $to   = isset($_GET['to']) ? $_GET['to'] : date('d/m/Y');

        $formatFrom = $this->dateEmMysql($from);
        $formatTo   = $this->dateEmMysql($to);

        if($this->checkAdmin()) {
            $receive = Transaction::select('transactions.*')
                ->join('users', 'transactions.to_user_id', '=', 'users.id')
                ->where([
                    ['transactions.status', '<>', 2],
                    ['users.level', 1],
                    ['transactions.is_20', 1],
                    ['transactions.updated_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                    ['transactions.updated_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                ])
                ->orderBy('updated_at', 'desc');

            $receiveTotal = Transaction::select('transactions.*')
                ->join('users', 'transactions.to_user_id', '=', 'users.id')
                ->where([
                    ['transactions.status', '<>', 2],
                    ['users.level', 1],
                    ['transactions.is_20', 1],
                ])
                ->orderBy('updated_at', 'desc');
        } else {
            $receive = Transaction::where([
                ['to_user_id', Auth::id()],
                ['status', '<>', 2],
                ['updated_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                ['updated_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                ['is_20', 1],
                ['hash', '<>', '2f1729abc064a22ba8c4fa4f862529cea440b8e326b4db751cc3c88a082c294b'],
                ['hash', '<>', 'a35404de595e556737730cd596621858be425157dd4d6f8dd6aad3e0de103321'],
                ['hash', '<>', '82B6E19189719BAD90C733E323FE2D12238C35695FFC759D5AB5A3744F873477'],
                ['hash', '<>', 'DF585B4005B16B92E86D8933AD2B7ED57C265A3BB40DFEF08007C12E991B3018'],
                ['hash', '<>', '27FC4812A9715AFE4E94A8BDB5C9D233D2D392FA509239B87EAA21CD9D55DBD8'],
                ['hash', '<>', 'D0A3C9CABA2314E442A09241A7FFBE704C93079587E54BDE01BEE36AAFDEA964'],
                ['hash', '<>', 'DC4ECE3A2F720A9A8F53D6E903D8523F834403494404B71263B1CBAA2B32FED6'],
                ['hash', '<>', '736ACFD541AB3221191520417867FE0645209F93690FBC7467271C74C9D64D13'],
                ['hash', '<>', '469FFCE6705FB934FA867C7D7992C08BAA1E09BD51A70D8149ED587E3309C61C'],
                ['hash', '<>', '96C3386DFA9DBECF944F6DFFE8ADA6E6FEB4F0F77BB306E02CFD4ECC93412454'],
                ['hash', '<>', '9C29249261317D751221D7BE81A81032DC367D5146D47A915BDDB4B9ADB92C99'],
                ['hash', '<>', 'B08923296FC093F385280ED87B1EA9C3102A0A047D7A32DBB9E6C0F8F969307E'],
                ['hash', '<>', '8AA914243E491389F2E38FC2A0FF7DAB12A4C94D12AB8517C29F3190FEC316F0'],
                ['hash', '<>', 'DC79272B8A3DED5E21C385A129DE7991E746777DA4AAEA3CFD1F183220832B9F'],
                ['hash', '<>', '23614DADC47905F71D7C4E5318885E182E77E793805F82093322D184DECBF8FA'],
                ['hash', '<>', '0AC401C069EA5BFA036C4BDB0A434E538ADFC43A805CA6A8CA66FF2DBF645C0B'],
                ['hash', '<>', 'B195A0A395291530107759F0CD1064C3782B4321D31268D3A0F260E10ED67300'],
                ['hash', '<>', '8BE3A71AB271E02C04E2A6518C036575459D490D8BE81BD66099EE8852905E7A'],
                ['hash', '<>', 'AD77C49C5767EEDC8AC7E80BF694B9FA86D83718895CCB5DBB88F814FE2FE2E1'],
                ['hash', '<>', '2C540FB04CA5AC6D61AEEE4036EC0184B057207BE35E20A078FAD329360EC353'],
                ['hash', '<>', '14B9D8AD9FD959E740940ED31018CCEA36DF77ED32F0DDCA790CEE5718CD5187'],
                ['hash', '<>', 'CF4E5801B344B530BE0AA57F6A9E3082D2C98062F2D7C571192980AAEB708B0A'],
                ['hash', '<>', '29BB78CED13EFD46F32FF7D72ADFF30A453297A86DE2641D5C61FB50740E251D'],
                ['hash', '<>', '9157391264127F522CA9AECC4E5B29452EFB747EE92668E8D0C21B2D98F057EC'],
                ['hash', '<>', 'EAFFAB833AB7C33AABA3A9B913CD2BE47381049EF7CD7D3B9AD55A9F79E27C5D'],
                ['hash', '<>', '5CE6BB3729E8D8436ABA6362124FA62C358A4E1C5B60EF4348D59E176052475A'],
                ['hash', '<>', '7C2E7F803276897E4A9343AA0EDF72C3551F72BAD29D0FB5EA46C341D02C1B35'],
                ['hash', '<>', '7189E07FFB83A6EB006F1EB8F2A3816D785E843D537B7F1E488291755C9D460C'],
                ['hash', '<>', '75CF36DBFB07D51E4702AB332B5B04F6E4C323010A3DCBE2D407B492475C0DF5'],
                ['hash', '<>', 'FF80DF263E26CD1C96880A9317A5F32491E2FADD6AA01000A04188EA9F4546CA'],
                ['hash', '<>', '5AC7AEBC46C88888CC0C1EA5833F83734AF73D88DA3B5464FA42F210BF0283A2'],
                ['hash', '<>', '001FC705F05AA5FEE790146E256F501DDEC4E370E41D0D994F7EE84AE6E148E6'],
                ['hash', '<>', 'A70DD904B2B2BC45EEB03B20532DA1BCED2C8532A5A93DAF99FCBF7325D04FF6'],
                ['hash', '<>', 'F210688D811642784111CED8D47F2729D51C78FB52317F6F345EFF0F7485AD5F'],
                ['hash', '<>', '3620AAF88F47FF37A1B90225E37DA942104AE34E75C79AA97DE31D13EB2A830E'],
                ['hash', '<>', '9D29EFEBA7880EB53F4A640B370B96DA7EEDF2651E4E950C411E573212DBD0DF'],
                ['hash', '<>', '5CAA9E9E53757E22773D57BF42BFFDDD130625567468EE217BC8F960860C5149'],
                ['hash', '<>', 'C26C7E732221C682FAF2CF761BE2B0F6DD58703BABE16D55956C0D0810F4C19E'],
                ['hash', '<>', '6720CF69CBD1076B5A0F5A056B575B61EEDF66B34234C327C4B6F8EBC75B15C6'],
                ['hash', '<>', '6DC4643C1D73B5B320DFBB5F629ABA9B5D661C3951AFE6C8D4F7DCB2FBFAB1E8'],
            ])
            ->orderBy('updated_at', 'desc');

            $receiveTotal = Transaction::where([
                ['to_user_id', Auth::id()],
                ['status', '<>', 2],
                ['is_20', 1],
                ['hash', '<>', '2f1729abc064a22ba8c4fa4f862529cea440b8e326b4db751cc3c88a082c294b'],
                ['hash', '<>', 'a35404de595e556737730cd596621858be425157dd4d6f8dd6aad3e0de103321'],
                ['hash', '<>', '82B6E19189719BAD90C733E323FE2D12238C35695FFC759D5AB5A3744F873477'],
                ['hash', '<>', 'DF585B4005B16B92E86D8933AD2B7ED57C265A3BB40DFEF08007C12E991B3018'],
                ['hash', '<>', '27FC4812A9715AFE4E94A8BDB5C9D233D2D392FA509239B87EAA21CD9D55DBD8'],
                ['hash', '<>', 'D0A3C9CABA2314E442A09241A7FFBE704C93079587E54BDE01BEE36AAFDEA964'],
                ['hash', '<>', 'DC4ECE3A2F720A9A8F53D6E903D8523F834403494404B71263B1CBAA2B32FED6'],
                ['hash', '<>', '736ACFD541AB3221191520417867FE0645209F93690FBC7467271C74C9D64D13'],
                ['hash', '<>', '469FFCE6705FB934FA867C7D7992C08BAA1E09BD51A70D8149ED587E3309C61C'],
                ['hash', '<>', '96C3386DFA9DBECF944F6DFFE8ADA6E6FEB4F0F77BB306E02CFD4ECC93412454'],
                ['hash', '<>', '9C29249261317D751221D7BE81A81032DC367D5146D47A915BDDB4B9ADB92C99'],
                ['hash', '<>', 'B08923296FC093F385280ED87B1EA9C3102A0A047D7A32DBB9E6C0F8F969307E'],
                ['hash', '<>', '8AA914243E491389F2E38FC2A0FF7DAB12A4C94D12AB8517C29F3190FEC316F0'],
                ['hash', '<>', 'DC79272B8A3DED5E21C385A129DE7991E746777DA4AAEA3CFD1F183220832B9F'],
                ['hash', '<>', '23614DADC47905F71D7C4E5318885E182E77E793805F82093322D184DECBF8FA'],
                ['hash', '<>', '0AC401C069EA5BFA036C4BDB0A434E538ADFC43A805CA6A8CA66FF2DBF645C0B'],
                ['hash', '<>', 'B195A0A395291530107759F0CD1064C3782B4321D31268D3A0F260E10ED67300'],
                ['hash', '<>', '8BE3A71AB271E02C04E2A6518C036575459D490D8BE81BD66099EE8852905E7A'],
                ['hash', '<>', 'AD77C49C5767EEDC8AC7E80BF694B9FA86D83718895CCB5DBB88F814FE2FE2E1'],
                ['hash', '<>', '2C540FB04CA5AC6D61AEEE4036EC0184B057207BE35E20A078FAD329360EC353'],
                ['hash', '<>', '14B9D8AD9FD959E740940ED31018CCEA36DF77ED32F0DDCA790CEE5718CD5187'],
                ['hash', '<>', 'CF4E5801B344B530BE0AA57F6A9E3082D2C98062F2D7C571192980AAEB708B0A'],
                ['hash', '<>', '29BB78CED13EFD46F32FF7D72ADFF30A453297A86DE2641D5C61FB50740E251D'],
                ['hash', '<>', '9157391264127F522CA9AECC4E5B29452EFB747EE92668E8D0C21B2D98F057EC'],
                ['hash', '<>', 'EAFFAB833AB7C33AABA3A9B913CD2BE47381049EF7CD7D3B9AD55A9F79E27C5D'],
                ['hash', '<>', '5CE6BB3729E8D8436ABA6362124FA62C358A4E1C5B60EF4348D59E176052475A'],
                ['hash', '<>', '7C2E7F803276897E4A9343AA0EDF72C3551F72BAD29D0FB5EA46C341D02C1B35'],
                ['hash', '<>', '7189E07FFB83A6EB006F1EB8F2A3816D785E843D537B7F1E488291755C9D460C'],
                ['hash', '<>', '75CF36DBFB07D51E4702AB332B5B04F6E4C323010A3DCBE2D407B492475C0DF5'],
                ['hash', '<>', 'FF80DF263E26CD1C96880A9317A5F32491E2FADD6AA01000A04188EA9F4546CA'],
                ['hash', '<>', '5AC7AEBC46C88888CC0C1EA5833F83734AF73D88DA3B5464FA42F210BF0283A2'],
                ['hash', '<>', '001FC705F05AA5FEE790146E256F501DDEC4E370E41D0D994F7EE84AE6E148E6'],
                ['hash', '<>', 'A70DD904B2B2BC45EEB03B20532DA1BCED2C8532A5A93DAF99FCBF7325D04FF6'],
                ['hash', '<>', 'F210688D811642784111CED8D47F2729D51C78FB52317F6F345EFF0F7485AD5F'],
                ['hash', '<>', '3620AAF88F47FF37A1B90225E37DA942104AE34E75C79AA97DE31D13EB2A830E'],
                ['hash', '<>', '9D29EFEBA7880EB53F4A640B370B96DA7EEDF2651E4E950C411E573212DBD0DF'],
                ['hash', '<>', '5CAA9E9E53757E22773D57BF42BFFDDD130625567468EE217BC8F960860C5149'],
                ['hash', '<>', 'C26C7E732221C682FAF2CF761BE2B0F6DD58703BABE16D55956C0D0810F4C19E'],
                ['hash', '<>', '6720CF69CBD1076B5A0F5A056B575B61EEDF66B34234C327C4B6F8EBC75B15C6'],
                ['hash', '<>', '6DC4643C1D73B5B320DFBB5F629ABA9B5D661C3951AFE6C8D4F7DCB2FBFAB1E8'],
            ])
            ->orderBy('updated_at', 'desc');
        }

        $donationsPerDay = [];
        $totalConfirmed = 0;
        $totalPending   = 0;
        $total          = 0;

        foreach($receive->get() as $r) {
            if(empty($r->user_plan_id) && $r->status != 1) {

            } else {
                if($r->status == 1) {
                    $totalConfirmed += $r->value;
                }

                if($r->status == 0 && !is_null($r->user_plan_id)) {
                    $totalPending += $r->value;
                }

                $date = date('Y-m-d', strtotime($r->updated_at));

                if(array_key_exists($date, $donationsPerDay)) {
                    $donationsPerDay[$date] += $r->value;
                } else {
                    $donationsPerDay[$date] = $r->value;
                }
            }
        }

        foreach($receiveTotal->get() as $r) {
            if(empty($r->user_plan_id) && $r->status != 1) {

            } else {
                $total += $r->value;
            }
        }


        $donationsPerDay = array_reverse($donationsPerDay);

        return view('reports.donations.received' , [
            'receives'       => $receive->get(),
            'totalConfirmed' => $totalConfirmed,
            'totalPending'   => $totalPending,
            'total'          => $total,
            'from'           => $from,
            'to'             => $to,
            'donationsPerDay' => $donationsPerDay,
            'config'         => $this->config()
        ]);
    }

    public function donationsMade_20()
    {
        $from = isset($_GET['from']) ? $_GET['from'] : '01'.date('/m/Y');
        $to   = isset($_GET['to']) ? $_GET['to'] : date('d/m/Y');

        $formatFrom = $this->dateEmMysql($from);
        $formatTo   = $this->dateEmMysql($to);

        if($this->checkAdmin()) {
            $donate = Transaction::select('transactions.*')->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
            ->where([
                ['transactions.status', '<>', 2],
                ['transactions.updated_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                ['transactions.updated_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                ['transactions.is_20', 1],
            ])
            ->whereIn('user_plans.user_id', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,485,486,487,488,489,490,491,492,493,494,3145,3146,3147,3148,3149,3150,3151,3152,3153,3154,3155,3156,3157,3158,3159,3160,3243,3244])
            ->where([
                ['transactions.status', '<>', 2],
                ['transactions.updated_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                ['transactions.updated_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                ['transactions.is_20', 1],
            ])
            ->orderBy('updated_at', 'desc');

            $donateTotal = Transaction::select('transactions.*')->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
            ->where([
                ['transactions.status', '<>', 2],
                ['transactions.is_20', 1],
            ])
            ->whereIn('user_plans.user_id', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,485,486,487,488,489,490,491,492,493,494,3145,3146,3147,3148,3149,3150,3151,3152,3153,3154,3155,3156,3157,3158,3159,3160,3243,3244])
            ->where([
                ['transactions.status', '<>', 2],
            ])
            ->orderBy('updated_at', 'desc');

        } else {
            $donate = Transaction::select('transactions.*')->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
            ->where([
                ['user_plans.user_id', Auth::id()],
                ['transactions.status', '<>', 2],
                ['transactions.updated_at', '>=', Carbon::parse($formatFrom)->toDateString() . ' 00:00:00'],
                ['transactions.updated_at', '<=', Carbon::parse($formatTo)->toDateString() . ' 23:59:00'],
                ['transactions.is_20', 1],
            ])->orderBy('updated_at', 'desc');

            $donateTotal = Transaction::select('transactions.*')->join('user_plans', 'transactions.user_plan_id', '=', 'user_plans.id')
            ->where([
                ['user_plans.user_id', Auth::id()],
                ['transactions.status', '<>', 2],
                ['transactions.is_20', 1],
            ])->orderBy('updated_at', 'desc');
        }

        $donationsPerDay = [];
        $totalConfirmed = 0;
        $totalPending   = 0;
        $total          = 0;

        foreach($donate->get() as $d) {

            if($d->status == 1) {
                $totalConfirmed += $d->value;
            }

            if($d->status == 0 && !is_null($d->user_plan_id)) {
                $totalPending += $d->value;
            }

            $date = date('Y-m-d', strtotime($d->updated_at));

            if(array_key_exists($date, $donationsPerDay)) {
                $donationsPerDay[$date] += $d->value;
            } else {
                $donationsPerDay[$date] = $d->value;
            }
        }

        foreach($donateTotal->get() as $d) {
            $total += $d->value;
        }

        $donationsPerDay = array_reverse($donationsPerDay);

        return view('reports.donations.made' , [
            'donations'      =>  $donate->get(),
            'totalConfirmed' =>  $totalConfirmed,
            'totalPending'   =>  $totalPending,
            'total'          =>  $total,
            'from'           => $from,
            'to'             => $to,
            'donationsPerDay' => $donationsPerDay,
            'config'         =>  $this->config()
        ]);
    }
}
