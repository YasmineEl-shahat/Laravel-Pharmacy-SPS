@extends('layouts.dashboard')

@section('content')
    <a href="{{ route('areas.create') }}" class="btn btn-primary">Create New Area</a>
    <br>
    <form action="" method="">
        <input type="text" name="searchkeyword" id="myBox">
    </form>
    <table class="table table-bordered yajra-datatable" id="koko">
        <thead>
            <tr>
                <th>ID</th>
                <th>Country</th>
                <th>Name Of Area</th>
                <th>Action</th>
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
                    url: '/areas/' + formId,
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
                data: 'country_id',
                name: 'country_id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'action',
                name: 'action',
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
                    url: '/areas',
                    type: 'GET',
                },
            });

            //Requesting data
            $("#myBox").on('keyup', function() {
                var ser = $('#myBox').val();
                console.log("Search keyWord : " + ser);
                $.ajax({
                    method: "GET",
                    url: '/areas',
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
@endsection
