@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Request overview</div>

                <div class="panel-body">
                     <table class="table table-striped">
                            <tr>
                                <th>Name</th>
                                <th>Phone number</th>
                                <th>E-mail</th>
                                <th>Company</th>
                                <th>Address</th>
                                <th>Postal code</th>
                                
                            </tr>

                                    @foreach($request as $data)
                                          <tr class="bhv-row" id="data-info{{ $data->id }}">
                                              <td class="data-name">
                                                <p>{{$data->name}}</p>
                                              </td>
                                              <td class="data-phonenumber">
                                                <p>{{$data->phonenumber}}</p>
                                              </td>
                                              <td class="data-email">
                                                <p>{{$data->email}}</p>
                                              </td>
                                              <td class="data-company">
                                                <p>{{$data->company}}</p>
                                              </td>
                                              <td class="data-address">
                                                <p>{{$data->address}}</p>
                                              </td>
                                              <td class="data-postalcode">
                                                <p>{{$data->postalcode}}</p>
                                              </td>



                                          </tr>
                                    @endforeach


                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
