@extends('layouts_procurement.app')
@section('pageTitle', 'All Notifications')
@section('pageMenu', 'active')
@section('content')

    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="col-md-12">
                @include('ShareView.operationCallBackAlert')
            </div>
            
            <div class="col-md-12">
                <div class="box-header with-border hidden-print">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="box-title"><b>Item Request Notifications</b></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4 style="font-size: 14px; text-decoration: none;">
                                <i class="fa fa-bell"></i> Total Notifications: {{ $getNotificationList->count() }}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box-header with-border hidden-print text-center">
                            <hr>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-condensed table-bordered">
                                <thead class="text-gray-b">
                                    <tr>
                                        <th>S/N</th>
                                        <th>ITEM</th>
                                        <th>REASON</th>
                                        <th>SENDER NAME</th>
                                        <th>DEPARTMENT/UNIT</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $n=1; @endphp
                                    @foreach($getNotificationList as $list)
                                        <tr class="notification-row @if($list->is_read == 1) read-notification @else unread-notification @endif" 
                                            onclick="markAsRead('{{ $list->notificationID }}', this)">
                                            <td>{{$n++}}</td>
                                            <td class="font-weight-bold">{{ $list->item }}</td>
                                            <td>{{ $list->reason }}</td>
                                            <td class="font-weight-bold">{{ $list->name }}</td>
                                            <td class="font-weight-bold">{{ $list->unit }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="funcdelete('{{ base64_encode($list->notificationID) }}')">
                                                    <i class="fa fa-trash mr-1"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($getNotificationList->count() == 0)
                        <div class="text-center py-5">
                            <div class="text-muted">
                                <i class="fa fa-bell-slash fa-3x mb-3"></i>
                                <h4>No Notifications</h4>
                                <p>There are no item request notifications at this time.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .page-break {
            page-break-before: always;
        }

        @media print {
            .print-hidden {
                display: none !important;
            }
        }

        .read-notification td {
            text-decoration: line-through;
            background-color: #f8f9fa;
            color: #6c757d;
        }

        .unread-notification {
            background-color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .unread-notification:hover {
            background-color: rgba(0, 123, 255, 0.04);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .notification-row {
            transition: all 0.3s ease;
        }

        .btn {
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.04);
        }
    </style>

@endsection

@section('scripts')
<script>
    function markAsRead(notificationID, element) {
        // Send an AJAX request to mark the notification as read
        fetch('/mark-notification-as-read/' + notificationID, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                _token: '{{ csrf_token() }}'
            })
        })
        .then(response => {
            if (response.ok) {
                // If the request was successful, apply the read style
                element.classList.add('read-notification');
                element.classList.remove('unread-notification');
                // Decrease the notification count
                var notificationCountElement = document.getElementById('notification-count');
                if (notificationCountElement) {
                    var notificationCount = parseInt(notificationCountElement.textContent);
                    if (!isNaN(notificationCount) && notificationCount > 0) {
                        notificationCountElement.textContent = notificationCount - 1;
                        // Update the notification count in the backend
                        fetch('/update-notification-count', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                _token: '{{ csrf_token() }}',
                                notificationCount: notificationCount - 1
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                console.error('Error updating notification count in the backend');
                            }
                        })
                        .catch(error => console.error('Error updating notification count in the backend:', error));
                    }
                }
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
    }

    window.addEventListener('load', function() {
        fetchNotificationCount();
    });

    function fetchNotificationCount() {
        fetch('/get-updated-notification-count', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            const notificationCountContainer = document.getElementById('notification-count-container');
            if (notificationCountContainer) {
                if (data.notificationCount > 0) {
                    const badge = document.getElementById('notification-count');
                    badge.textContent = data.notificationCount;
                    notificationCountContainer.style.display = 'inline-block'; // Show the container
                }
            }
        })
        .catch(error => console.error('Error fetching updated notification count:', error));
    }

    function updateNotificationCount(count) {
        fetch('/update-notification-count', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                _token: '{{ csrf_token() }}',
                notificationCount: count
            })
        })
        .then(response => {
            if (!response.ok) {
                console.error('Error updating notification count in the backend');
            }
        })
        .catch(error => console.error('Error updating notification count in the backend:', error));
    }

    function funcdelete(x) {
        if(confirm('Are you sure you want to delete this notification?')) {
            document.location = '/delete-notification/'+x;
        }
    }
</script>
@endsection