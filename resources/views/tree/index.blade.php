@extends('layouts.app', ['title' => __('Tree'), 'page' => 'tree'])

@push('styles')
    <style type="text/css">
        .hiddenRow {
            padding: 0 !important;
        }
    </style>
@endpush

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
                           <h3 class="col-12 mb-0" style="padding-bottom: 20px;">Tree</h3>
                       </div>
                   </div>
                   <div class="row align-items-center">
                       <table class="table table-condensed table-striped">
                           <thead>
                               <tr class="text-center">
                                   <th>Firts Level</th>
                                   <th>Second Level</th>
                                   <th>Three Level</th>
                                   <th>Four Level</th>
                               </tr>
                           </thead>
                           <tbody>
                                @foreach($one_level as $index => $user)
                                <tr class="text-center">
                                    <td>{{ $user->username }}</td>
                                    <td>
                                        <button class="btn btn-secondary btn-xs py-1" data-toggle="collapse" data-target="#demo{{ $index }}_2" class="accordion-toggle">
                                            <span class="fa fa-plus-circle"> Number</span>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-secondary btn-xs py-1" data-toggle="collapse" data-target="#demo{{ $index }}_3" class="accordion-toggle">
                                            <span class="fa fa-plus-circle"> Number</span>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-secondary btn-xs py-1" data-toggle="collapse" data-target="#demo{{ $index }}_4" class="accordion-toggle">
                                            <span class="fa fa-plus-circle"> Number</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12" class="hiddenRow">
                                        <div class="accordian-body collapse" id="demo{{ $index }}_2"> 
                                            <table class="table table-striped">
                                                <thead>
                                                   <tr class="text-center">
                                                       <th>Username - Second Level</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($two_level[$index] as $user1)
                                                    <tr data-toggle="collapse" class="accordion-toggle text-center">
                                                        @if(!empty($user1->username))
                                                        <td>{{ $user1->username }}</td>
                                                        @endif
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div> 
                                        <div class="accordian-body collapse" id="demo{{ $index }}_3"> 
                                            <table class="table table-striped">
                                                <thead>
                                                   <tr class="text-center">
                                                       <th>Username - Three Level</th>
                                                   </tr>
                                                </thead> 
                                                <tbody>
                                                    @if(isset($tres_level[$index]))
                                                    @foreach($tres_level[$index] as $user2)
                                                    <tr data-toggle="collapse" class="accordion-toggle text-center">
                                                        @if(!empty($user2->username))
                                                        <td>{{ $user2->username }}</td>
                                                        @endif
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="accordian-body collapse" id="demo{{ $index }}_4"> 
                                            <table class="table table-striped">
                                                <thead>
                                                   <tr class="text-center">
                                                       <th>Username - Four Level</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($four_level[$index]))
                                                    @foreach($four_level[$index] as $user3)
                                                    <tr data-toggle="collapse" class="accordion-toggle text-center">
                                                        @if(!empty($user3->username))
                                                        <td>{{ $user3->username }}</td>
                                                        @endif
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div> 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('layouts.footers.auth')
</div>
@endsection

@push('js')

<script type="text/javascript">
    $(function() {
        $('button.btn').on('click', function () {
            $('.collapse').collapse('hide');
        });
    });
</script>

@endpush