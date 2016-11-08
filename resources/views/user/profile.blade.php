@extends('layouts.gui', ['name' => 'Profile'])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>

                <div class="panel-body">
                    <table style="border-spacing: 3em; border-collapse: separate;">
                        <tr>
                            <td style="text-align: right;">
                                <strong>Username</strong>
                            </td>
                            <td>
                                {{ Auth::user()->name }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">
                                <strong>Email</strong>
                            </td>
                            <td>
                                {{ Auth::user()->email }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">
                                <strong>Account</strong>
                            </td>
                            <td>
                                @role('admin')
                                    Admin
                                @else
                                    User
                                @endrole
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
