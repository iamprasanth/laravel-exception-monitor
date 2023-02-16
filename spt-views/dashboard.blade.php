@extends('spt-views.main')
@section('content')
<content>
    <div class="spt-exception-dashboard">
        <div class="spt-exception-nav">
            <h4>{{__('spt.main_heading')}}</h4>
        </div>
        <div class="spt-exception-overview p-3">
            <div class="row">
                <div class="col-12 col-xl-12">
                    <ul class="spt-button-list d-flex list-unstyled m-0 align-items-end mb-3">
                        <li>
                            <div class="input-group-1">
                                <label class="control-label">{{__('spt.type')}}</label>
                                <select class="form-control select-filter" onchange=filterLogs()>
                                    <option value="All">{{__('spt.All')}}</option>
                                    <option value="EMERGENCY">{{__('spt.Emergency')}}</option>
                                    <option value="ALERT">{{__('spt.Alert')}}</option>
                                    <option value="CRITICAL">{{__('spt.Critical')}}</option>
                                    <option value="ERROR">{{__('spt.Error')}}</option>
                                    <option value="WARNING">{{__('spt.Warning')}}</option>
                                    <option value="NOTICE">{{__('spt.Notice')}}</option>
                                    <option value="INFO">{{__('spt.Info')}}</option>
                                    <option value="DEBUG">{{__('spt.Debug')}}</option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <div class="input-group-date">
                                <label class="control-label">{{__('spt.from')}}</label>
                                <input id="from_date" class="datepicker form-control" readonly="true" onchange="filterLogs(null)" type="text"
                                    class="form-control spt-datepicker" value="{{$data['from_date']}}">
                            </div>
                        </li>
                        <li>
                            <div class="input-group-date">
                                <label class="control-label">{{__('spt.to')}}</label>
                                <input id="to_date" class="datepicker form-control" readonly="true" onchange="filterLogs(null)" type="text"
                                    class="form-control spt-datepicker" value="{{$data['to_date']}}">
                            </div>
                        </li>
                    </ul>
                </div>
                @if ($data['success'] == true)
                <div class="col-12 col-xl-12">
                    <canvas id="error_log_chart" width="400" height="140"></canvas>
                </div>
                @endif
                <div class="col-12 col-xl-12">
                    <div class="spt-exception-card-wrapper">
                        <div class="container">
                            <div class="row">
                            <!-- @foreach($data['chart']['data_sets'] as $dataSet)
                                <div class="col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                    <div class="log-card p-3 br-{{ $dataSet['color'] }}">
                                        <ul class="d-flex p-0 list-unstyled m-0 align-items-center">
                                            <li>
                                                <h5>{{ $dataSet['label'] }}</h5>
                                                <h3 class="m-0 {{ $dataSet['color'] }}">{{ (isset($dataSet['data'])) ? array_sum($dataSet['data']) : 0 }}</h3>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach -->
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <div class="spt-exception-table spt-exception-daily-log p-3">
            @if ($data['success'] == true)
            <div class="d-flex align-items-center spt-table-title justify-content-between mb-3">
                <h2>{{__('spt.logs') }}</h2>
                <!-- <h2>{{__('spt.exception_log_from') }} - {{$data['from_date']}} {{ $data['from_date'] != $data['to_date'] ? __('spt.to').' '.$data['to_date'] : '' }}</h2> -->
                <input type="hidden" id="filter_dates" value='{!! json_encode($data["chart"]["dates"]) !!}'>
                <input type="hidden" id="data_sets" value='{{ json_encode($data["chart"]["data_sets"]) }}'>
            </div>
            <div class="table-responsive">
                <table id="logs" class="text-left my-3">
                    <thead>
                        <th>{{__('spt.ENV')}}</th>
                        <th>{{__('spt.type')}}</th>
                        <th>{{__('spt.Time')}}</th>
                        <th>{{__('spt.Message')}}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($data['logs'] as $key => $value)
                        <tr>
                            <td>{{$value['env']}}</td>
                            <td>
                                @if($value['type'] == 'EMERGENCY')
                                <span class="dark-red bold"><i class="fa fa-bug"
                                        aria-hidden="true"></i>{{__('spt.Emergency')}}</span>
                                @elseif($value['type'] == 'ALERT')
                                <span class="red bold"><i class="fa fa-bullhorn"
                                        aria-hidden="true"></i>{{__('spt.Alert')}}</span>
                                @elseif($value['type'] == 'CRITICAL')
                                <span class="light-red bold"><i class="fa fa-heartbeat"
                                        aria-hidden="true"></i>{{__('spt.Critical')}}</span>
                                @elseif($value['type'] == 'ERROR')
                                <span class="orange bold"><i class="fa fa-times-circle"
                                        aria-hidden="true"></i>{{__('spt.Error')}}</span>
                                @elseif($value['type'] == 'WARNING')
                                <span class="yellow bold"><i class="fa fa-exclamation-triangle"
                                        aria-hidden="true"></i>{{__('spt.Warning')}}</span>
                                @elseif($value['type'] == 'NOTICE')
                                <span class="green bold"><i class="fa fa-info-circle"
                                        aria-hidden="true"></i>{{__('spt.Notice')}}</span>
                                @elseif($value['type'] == 'DEBUG')
                                <span class="light-blue bold"><i class="fa fa-life-ring"
                                        aria-hidden="true"></i>{{__('spt.Debug')}}</span>
                                @elseif($value['type'] == 'INFO')
                                <span class="blue bold"><i class="fa fa-info-circle"
                                        aria-hidden="true"></i>{{__('spt.Info')}}</span>
                                @endif
                            </td>
                            <td>{{date('d-m-Y h:i:s', strtotime($value['timestamp']))}}</td>
                            <td>{{$value['message']}}</td>
                            <td>
                                <input type="hidden" id="detailed_message_{{ $key }}" value="{{ $value['detail'] }}">
                                <a onclick="viewException({{ $key }})" class="filter btn btn-dark active"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="d-flex align-items-center spt-table-title justify-content-between mb-3">
                    <h2>{{$data['message']}}</h2>
                </div>
                @endif
                <div id="viewException" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{__('spt.detailed_message')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="form-group">
                                            <textarea class="form-control" rows="15"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</content>
@section('script')
<script src="{{ asset('/js/spt-js/custom.js') }}"></script>
@endsection
@endsection
