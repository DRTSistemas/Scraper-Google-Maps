<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

use App\Http\Controllers\BaseController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\TreeController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ConfigAdminController;
use App\Http\Controllers\Admin\WalletAdminController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Admin\PlanAdminController;
use App\Http\Controllers\Admin\UserAdminController;

use App\Plan;
use App\UserPlan;
use App\User;
use App\Request as ModelRequest;

use App\Services\BscScanService;

Route::get('/', function () {
    return redirect()->route('home');
})->name('site.home')->middleware('guest');

Route::get('/clear', function () {
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');
    \Artisan::call('optimize:clear');
    dd("Cache is cleared");
})->middleware('guest');

Route::get('/storagelink', function () {
    Artisan::call('storage:link');
});

Route::get('/query', function(Request $request) {
	//echo $request->input('search');
	
	$newRequests = 500;
	
	$plan = Plan::get()->first(function ($plan) use ($newRequests) {
        return round($plan->plan_value / $plan->search_value) == $newRequests;
    });
    
    dd($plan);
});

Route::post('/celetusPaid', function () {
    
    $payload = file_get_contents('php://input');
    $order = json_decode($payload, true);

    $email = $order['email'];
    $code = $order['code'];

    // Buscar usuário pelo e-mail
    $user = User::where('email', $email)->first();

    // Buscar plano cujo link_checkout contém o código informado
    $plan = Plan::where('link_checkout', 'LIKE', "%$code%")->first();

    // Verifica se os dados foram encontrados
    if (!$user) {
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Usuário não encontrado']);
        exit();
    }

    if (!$plan) {
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Plano não encontrado']);
        exit();
    }

    $newPlan = new UserPlan;
    
    $newPlan->user_id = $user->id;
    $newPlan->plan_id = $plan->id;
    $newPlan->status = 1;
    $newPlan->requests_left = round($plan->plan_value / $plan->search_value);
    
    $newPlan->save();

    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode([
        'message' => 'Plano associado com sucesso!',
        'user' => $user->id,
        'plan' => $plan->id,
        'user_plan' => $newPlan->id
    ]);
    exit();

});

Auth::routes();
Route::impersonate();

// Rotas de Registro
Route::get('/register/{code?}', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/complete-registration', [RegisterController::class, 'completeRegistration']);

/*
// Rotas de Rotinas
Route::get('/routine', [RoutineController::class, 'index'])->name('routine');
Route::get('/routine/payment', [RoutineController::class, 'payment'])->name('routine.payment');
*/

/*
// Rotas de 2FA para Usuários
Route::get('/2fa', [TwoFactorController::class, 'show'])->name('2fa');
Route::post('/2fa', [TwoFactorController::class, 'verify'])->name('2fa.verify');

Route::middleware('auth')->group(function () {
    Route::get('/2fa/disabled', [UserController::class, 'formDisabled2FA'])->name('2fa.disabled');
    Route::post('/2fa/disabled', [UserController::class, 'disabled2FA'])->name('2fa.disabled');
    Route::get('/2fa/enable', [UserController::class, 'formEnable2FA'])->name('2fa.enable');
    Route::post('/2fa/enable', [UserController::class, 'enable2FA'])->name('2fa.enable');
});

Route::get('/2fa/activate', [Google2FAController::class, 'activate2FA'])->name('2fa.activate');
Route::post('/2fa/activate', [Google2FAController::class, 'assign2FA']);
Route::get('/2fa/deactivate', [Google2FAController::class, 'deactivate2FA'])->name('2fa.deactivate');
Route::get('/2fa/login', [Google2FAController::class, 'login2FA'])->name('2fa.login');
Route::post('/2fa/login', [Google2FAController::class, 'verify2FA']);
*/

Route::get('/login-2fa', [LoginController::class,'login2fa'])->name('2fa');
Route::post('/login-2fa', [LoginController::class, 'verify'])->name('2fa.verify');

Route::group(['middleware'=>['auth']], function () {
    Route::post('/enable-2fa', [TwoFactorController::class,'enable2Fa'])->name('enable-2fa');
    Route::post('/disabled-2fa', [TwoFactorController::class,'disabled2Fa'])->name('disabled-2fa');
    Route::post('/verify-2fa', [TwoFactorController::class,'verify2Fa'])->name('verify-2fa');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/search', [HomeController::class, 'search'])->name('search');

    Route::post('/search', [HomeController::class, 'searchRequest']);

    /*
    Route::get('/donation/{id}', [HomeController::class, 'getDonation'])->name('home.donate');

    Route::get('/chart', function () {

        $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth(5)->toDateString();
        $lastDayofPreviousMonth = Carbon::now()->subMonth(0)->endOfMonth()->toDateString();

        $req = UserPlan::select('user_plans.*')
                ->join('users', 'user_plans.user_id', '=', 'users.id')
                ->where([
                    ['users.indication_id', '=', Auth::id()],
                    ['user_plans.status', '=', 1],
                    ['user_plans.created_at', '>=', $firstDayofPreviousMonth],
                    ['user_plans.created_at', '<=', $lastDayofPreviousMonth . ' 23:59:59'],
                    //['user_plans.created_at', '>=', '2020-12-01']
                ])
                ->get();

        $result    = [];
        $usersUsed = [];
        $lastMonth = null;

        foreach($req as $val){
            $checkIfIsNew = UserPlan::where([
                //['status', '=', 1],
                ['created_at', '<', $val['created_at']],
                ['user_id', $val['user_id']]
                //['created_at', '>=', '2020-12-01']
            ]);

            if(substr($checkIfIsNew->first()['created_at'],0,7) == substr($val['created_at'],0,7) || $checkIfIsNew->get()->count() == 0 || substr($checkIfIsNew->first()['created_at'],0,7) == '2021-04' && substr($val['created_at'],0,10) == '2021-05-01') {

                if(substr($val['created_at'],0,10) == '2021-05-01') {
                    $val['created_at'] = '2021-04-30';
                }

                if(substr($val['created_at'],0,7) != $lastMonth) {
                    if(!in_array($val['user_id'], $usersUsed)) {
                        if(array_key_exists(substr($val['created_at'],0,7), $result)) {
                            $result[substr($val['created_at'],0,7)]+=$val->plan()->plan_value;
                        } else {
                            $result[substr($val['created_at'],0,7)]=$val->plan()->plan_value;
                            array_push($usersUsed, $val['user_id']);
                        }
                    }
                } else {
                    if(array_key_exists(substr($val['created_at'],0,7), $result)) {
                        $result[substr($val['created_at'],0,7)] += $val->plan()->plan_value;
                    } else {
                        $result[substr($val['created_at'],0,7)] = $val->plan()->plan_value;
                        array_push($usersUsed, $val['user_id']);
                    }
                }

                $lastMonth = substr($val['created_at'],0,7);
            }
        }

        return response()->json($result);

    });
    */

    Route::resource('plan', PlanController::class);

    /*
    // Rotas de Wallet
    Route::get('wallet/{is_update?}', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('wallet', [WalletController::class, 'store'])->name('wallet.store');
    Route::put('wallet/{id?}', [WalletController::class, 'update'])->name('wallet.update');
    */

    // Rotas de User
    Route::resource('user', UserController::class)->except(['show']);

    Route::get('profile/{verified?}/{tab?}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::put('profile/token', [ProfileController::class, 'token'])->name('profile.token');

    // Rotas de Transaction
    /*
    Route::resource('transaction', TransactionController::class);
    */

    // Grupo de Rotas para Relatórios
    Route::prefix('report')->group(function () {
        Route::get('searchs', [ReportController::class, 'searchs'])->name('searchs');

        /*
        // Rotas de Doações
        Route::get('donations/received', [ReportController::class, 'donationsReceived'])->name('donations.received');
        Route::get('donations/made', [ReportController::class, 'donationsMade'])->name('donations.made');
        Route::get('donations/received_20', [ReportController::class, 'donationsReceived_20'])->name('donations.received_20');
        Route::get('donations/made_20', [ReportController::class, 'donationsMade_20'])->name('donations.made_20');
        Route::get('donations/users', [ReportController::class, 'donationsUsers'])->name('donations.users');
        Route::get('donations/inline', [ReportController::class, 'donationsInline'])->name('donations.inline');
        Route::get('donations/processed', [ReportController::class, 'donationsProcessed'])->name('donations.processed');
        Route::get('donations/future', [ReportController::class, 'donationsFuture'])->name('donations.future');

        // Rotas de Bônus
        Route::get('bonus/direct', [ReportController::class, 'bonusDirect'])->name('bonus.direct');
        Route::get('bonus/indirect', [ReportController::class, 'bonusIndirect'])->name('bonus.indirect');

        // Rotas de Planos
        Route::get('plans/pending', [ReportController::class, 'pendingPlans'])->name('plans.pending');
        Route::get('plans/completed', [ReportController::class, 'completedPlans'])->name('plans.completed');
        */
    });

    /*
    // Grupo de Rotas para Bônus
    Route::prefix('bonus')->group(function () {
        Route::get('/', [BonusController::class, 'index'])->name('bonus.index');
        Route::post('/', [BonusController::class, 'store'])->name('bonus.store');
        Route::get('/master', [BonusController::class, 'master'])->name('bonus.master');
        Route::get('/referrals', [BonusController::class, 'referrals'])->name('bonus.referrals');
    });
    */

    /*
    // Grupo de Rotas para Árvore
    Route::prefix('tree')->group(function () {
        Route::get('/', [TreeController::class, 'index'])->name('tree.index');
    });
    */

    Route::post('/saveFile', function(Request $request) {

		$data = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'.$request->input('file');

		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);

        $filename = time() . '_' .$request->input('fileName');

		Storage::disk('public')->put('upload/'. $filename .'.xlsx', $data);

        $newRequest = new ModelRequest();
        $newRequest->user_id = auth()->user()->id;
        $newRequest->term = $request->input('term');
        $newRequest->filename = $filename;
        $newRequest->save();

        return true;
	});

    // Rota de Suporte
    Route::get('/support', [UserController::class, 'openSupport'])->name('support');
});

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    // Rotas principais de Admin
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/removeTransaction', [AdminController::class, 'removeTransaction'])->name('admin.removeTransaction');
    Route::post('/returnTransaction', [AdminController::class, 'returnTransaction'])->name('admin.returnTransaction');

    // Rotas de Masters
    Route::prefix('masters')->group(function () {
        Route::get('/', [AdminController::class, 'reportMasters'])->name('admin.master.index');
    });

    // Rotas de Diamonds
    Route::prefix('diamonds')->group(function () {
        Route::get('/', [AdminController::class, 'getPaymentDiamonds'])->name('admin.diamonds.index');
        Route::post('/', [AdminController::class, 'paymentDiamonds'])->name('admin.diamonds.store');
        Route::get('/activations', [AdminController::class, 'totalActivations'])->name('admin.diamonds.activations');
    });

    // Rotas de Configurações
    Route::resource('/config', ConfigAdminController::class, ['as' => 'admin']);

    // Rotas de Carteira
    Route::resource('/wallet', WalletAdminController::class, ['as' => 'admin']);

    // Rotas de Perfil
    Route::get('profile', [ProfileAdminController::class, 'edit'])->name('admin.profile.edit');
    Route::put('profile', [ProfileAdminController::class, 'update'])->name('admin.profile.update');
    Route::put('profile/password', [ProfileAdminController::class, 'password'])->name('admin.profile.password');

    // Rotas de Planos
    Route::get('/plan/activations', [PlanAdminController::class, 'activations'])->name('admin.plan.activations');
    Route::resource('/plan', PlanAdminController::class, ['as' => 'admin']);

    // Rotas de Usuários
    Route::get('/user/access/{id}/{sha1}', [UserAdminController::class, 'access'])->name('admin.user.access');
    Route::resource('/user', UserAdminController::class, ['as' => 'admin']);
});