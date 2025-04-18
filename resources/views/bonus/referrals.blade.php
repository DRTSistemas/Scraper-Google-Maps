@extends('layouts.app', ['title' => __('Bonus'), 'page' => 'bonus'])

@section('content')
    @include('users.partials.header', [
        'title' => '',
        'description' => '',
        'class' => ''
    ])
    <div class="container-fluid mt--7">
        <div class="row justify-content-center">
            <div class="col-xl-12 order-xl-2 mb-5 mb-xl-0">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                    <div class="row">
                                <div class="col-6">
                                    <h3 class="col-12 mb-0" style="padding-bottom: 20px;">Inactive Referrals</h3>
                                </div>
                            </div>
                        <div class="row align-items-center">
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Name</th>
                                            <th scope="col" class="text-center">Username</th>
                                            <th scope="col" class="text-center">E-mail</th>
                                            <th scope="col" class="text-center">WhatsApp Number</th>
                                            <th scope="col" class="text-center">Registration in</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($referrals as $referral)
                                            <tr class="text-center">
                                                <th class="text-center">
                                                    {{ $referral->name }}
                                                </th>
                                                <th class="text-center">
                                                    {{ $referral->username }}
                                                </th>
                                                <td class="text-center">
                                                    {{ $referral->email }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $referral->phone_number }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $referral->created_at->format('j F, Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $referrals->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection