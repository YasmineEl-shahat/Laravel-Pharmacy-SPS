@extends('layouts.dashboard')

@section('content')
    <a href="{{ route('orders.create') }}" class="btn btn-primary">Create New Order</a>
    <form action="" method="">
        <input type="text" name="searchkeyword" id="myBox">
    </form>
    <table class="table table-bordered yajra-datatable" id="koko">
        <thead>
            <tr>
                <th>ID</th>
                <th>Order User Name</th>
                <th>Delivering address </th>
                <th>Creation Date</th>
                <th>Doctor Name</th>
                <th>Is Insured</th>
                <th>Status</th>
                <th>Action</th>
                <th>testingName</th>
            </tr>
        </thead>
        <tbody id="tbodyid">
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        function myFunction(formId, formToken) {
            let result = confirm("Are you Sure you Want to Delete ? ");
            console.log(result);
            if (result) {
                let form = document.getElementById(formId);
                // form.submit();
                $.ajax({
                    url: '/orders/' + formId,
                    type: 'DELETE',
                    data: {
                        "id": formId,
                        "_token": formToken,
                    },
                    success: function(res) {
                        console.log("it Works");
                        Toastify({
                            text: res.success,
                            duration: 3000,
                            style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                            },
                        }).showToast();
                        myTable.DataTable().ajax.reload();
                    }
                });
            }
        }

        var myTable = $('#koko');
        var cols = [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'customer_id',
                name: 'customer_id'
            },
            {
                data: 'delivering_address_id',
                name: 'delivering_address_id'
            },
            {
                data: 'created_at',
                name: 'created_at',
            },
            {
                data: 'user_id',
                name: 'user_id',
            },
            {
                data: 'is_insured',
                name: 'is_insured',
            },
            {
                data: 'status',
                name: 'status',
            },
            {
                data: 'action',
                name: 'action',
            },
            {
                data: 'testingName',
                name: 'testingName',
            },
        ]
        let collections = {};
        $(document).ready(function() {
            //Initializing DataTables
            let collectionsTable = $("#koko").dataTable({
                destroy: true,
                "data": collections,
                "columns": cols,
                processing: true,
                serverSide: true,
                "searching": false,
                ajax: {
                    url: '/orders',
                    type: 'GET',
                },
            });
            //Requesting data
            $("#myBox").on('keyup', function() {
                var ser = $('#myBox').val();
                console.log("Search keyWord : " + ser);
                $.ajax({
                    method: "GET",
                    url: '/orders',
                    dataType: 'json',
                    data: {
                        'searchkeyWord': ser,
                        draw: parseInt(1),
                    },
                    success: function(r) {
                        assignToEventsColumns(r);
                    },
                });
            });

            function assignToEventsColumns(data) {
                if ($.fn.DataTable.isDataTable("#koko")) {
                    $('#koko').DataTable().clear().destroy();
                }
                $("#koko").dataTable({
                    "aaData": data.data,
                    "columns": cols,
                });
                console.log(data);
            }
        });
    </script>
    @if ($status = session('status'))
        <script>
            Toastify({
                text: '{{ $status }}',
                duration: 3000,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
            }).showToast();
        </script>
    @endif

    @if ($status = session('error'))
        <script>
            Toastify({
                text: '{{ $status }}',
                duration: 3000,
                style: {
                    background: "red",
                },
            }).showToast();
        </script>
    @endif
@endsection
