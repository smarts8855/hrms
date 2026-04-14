@extends('layouts_procurement.app')
@section('pageTitle', 'Email Logs')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <h3 class="panel-title"><b>Email Notification Logs</b></h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('upload-letters.index') }}" class="btn btn-sm btn-default">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Contract</th>
                                <th>Letter Type</th>
                                <th>Recipient</th>
                                <th>Sent By</th>
                                <th>Sent At</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $key => $log)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $log->contract_name ?? 'N/A' }}</td>
                                <td>
                                    <span class="label label-{{ $log->email_type == 'recommendation_letter' ? 'info' : 'success' }}">
                                        {{ ucfirst(str_replace('_', ' ', $log->email_type)) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $log->recipient_email }}<br>
                                    <small>{{ $log->recipient_name }}</small>
                                </td>
                                <td>{{ $log->sent_by_name ?? 'System' }}</td>
                                <td>{{ date('d M, Y h:i A', strtotime($log->sent_at)) }}</td>
                                <td>
                                    @if($log->status == 'sent')
                                        <span class="label label-success">Sent</span>
                                    @elseif($log->status == 'failed')
                                        <span class="label label-danger">Failed</span>
                                    @else
                                        <span class="label label-warning">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="alert alert-info">No email logs found</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection