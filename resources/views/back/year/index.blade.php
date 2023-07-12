@extends("back.common.master")
@section("page_name")
    {{__("year.yr_mng")}}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header blue"><span class="card-header-title">{{__("year.mng_yr")}}</span>
                        <a href="{{route("year.create")}}"
                           class="btn btn-sm btn-dark float-right"><i
                                class="fas fa-plus-circle mr-1"></i>{{__("year.add_yr")}}</a>
                    </div>
                    <div class="card-body yellow">
                        <div class="row">
                            <div class="col-12">
                                @include("common.messages")
                            </div>
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th>{{__("common.id")}}</th>
                                    <th>{{__("year.wrk_yr")}}</th>
                                    <th>{{__("common.action")}}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(!$years || $years->count()==0)
                                    <tr>
                                        <td colspan="3">
                                            <div class="alert alert-dark">{{__("year.no_wrk_yr_exist")}}!</div>
                                        </td>
                                    </tr>
                                @endif
                                @foreach($years as $year)
                                    <tr>
                                        <td>{{$year->id}}</td>
                                        <td>{{$year->year_from}} @if($common::getWorkingYear()==$year->id) <i
                                                class="fas fa-star"></i> @endif
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <a href="{{ route('year.edit', $year->id) }}"
                                                   class="btn btn-sm btn-dark action_btn"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                {{ Form::open([ 'method'  => 'delete', "id"=>"year_delete_".$year->id, 'route' => [ 'year.destroy', $year->id ] ]) }}
                                                <button class="btn btn-sm btn-danger action_btn"
                                                        onclick="confirm_then_submit('{{__("common.cnf_del")}}','year_delete_{{$year->id}}')"
                                                        type="button"><i
                                                        class="fa fa-trash"></i></button>
                                                {{ Form::close() }}
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
    </div>
@endsection
