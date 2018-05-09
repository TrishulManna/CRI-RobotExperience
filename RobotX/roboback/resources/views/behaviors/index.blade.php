@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <!-- <div class="panel-heading">Behaviors</div> -->

                    <div class="panel-body">
                        <p class="list-header">
                            <span class="behavior-header">Behaviors</span>
                            <span>
                                <a href="{{ route('behaviors.create') }}" class="btn btn-default align-right">
                                    <i class="fa fa-plus action-icon" title="New behavior"></i>
                                </a>
                            </span>
                            <span>
                                <span class="filter-label">Search:<span> <input id="bhv-search" onkeyup="doBhvSearch();"/>
                            </span>
                            <span>
                                <span class="filter-label">Language:</span>
                                <select class="filter-select" id="bhv-filter-language" onchange="doBhvSearch();">
                                    <option value="ALL" selected="selected">&nbsp;</option>
                                    <option value="Dutch">Dutch</option>
                                    <option value="English">English</option>
                                    <option value="German">German</option>
                                    <option value="French">French</option>
                                </select>
                            </span>
                            <span>
                                <span class="filter-label">Base Menu:</span>
                                <select class="filter-select" id="bhv-filter-basemenu" onchange="doBhvSearch();">
                                    <option value="ALL" selected="selected">&nbsp;</option>
                                    <option value="Dance menu">Dance</option>
                                    <option value="Greetings menu">Activities</option>
                                    <option value="Interaction menu">Interaction</option>
                                    <option value="Presentation menu">Presentation</option>
                                </select>
                            </span>
                            <span>
                                <span class="filter-label">Robot:<span>
                                <select class="filter-select-robot" id="bhv-filter-robot" onchange="doBhvSearch();">
                                    <option value="ALL" selected="selected">&nbsp;</option>
                                    @foreach ($robots as $robot)
                                        <option value="{!!$robot->name!!}">{!!$robot->name!!}</option>
                                    @endforeach
                                </select>
                            </span>
                            {{--  <a href="{{ route('behaviors.import') }}" class="btn btn-default align-right" data-title="Import behaviors" data-toggle="lightbox"><i class="fa fa-plus"></i> Import behaviors</a> --}}
                        </p>

                        <table class="table table-striped">
                            <tr>
                                <th></th>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Type of Behavior</th>
                                <th>Language</th>
                                <!-- Accepted as new table -->
                                <th>&nbsp;</th>
                                @if(\App\RoleUsers::where('user_id', Auth::id())->first()->role_id <= 2)
                                    <th>Accepted</th>
                                @endif
                            </tr>
                            @if(!$behaviors->count())
                                <tr>
                                    <td colspan="5">No behaviors added yet.</td>
                                </tr>
                            @endif

                            @foreach ($behaviors as $behavior)
                                <tr class="bhv-row" id="bhv-id-{{ $behavior->id }}">
                                    <td class="behavior-actions">
                                        <a href="{{ route('behaviors.edit', $behavior->id) }}" data-title="Edit behavior {{ $behavior->name }}" data-toggle="">
                                            <i class="fa fa-pencil pull-left list-icon"></i>
                                        </a>
                                        <a href="{{ route('behaviors.destroy', $behavior->id) }}" class="remove-confirm">
                                            <i class="fa fa-trash pull-right list-icon"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if (isset($behavior->icondata))
                                            <img class="list-icon-icon" src="{{ 'data:image/' . $behavior->icondata->type . ';base64,' . $behavior->icondata->icon }}"/>
                                        @else
                                            <i class="fa fa-smile-o list-icon"></i>
                                        @endif
                                    </td>
                                    <td class="bhv-name">{{ $behavior->name  }}</td>
                                    <td class="bhv-descr">{{ $behavior->description  }}</td>
                                    <td>{{ $behavior->behaviortype  }}</td>
                                    <td class="bhv-lang">{{ $behavior->language  }}</td>
                                    <td class="bhv-rbts">@if (isset($behavior->sayanimation) && $behavior->sayanimation == 'true')<i class="fa fa-child"></i>@else &nbsp; @endif</td>
                                    <td class="bhv-base" style="display: none">{{ $behavior->basemenu  }}</td>
                                    <td class="bhv-rbts" style="display: none">{{ $behavior->robots }}</td>

                                    <!--New buttons for accepted table-->
                                    <th>
                                        @if(\App\RoleUsers::where('user_id', Auth::id())->first()->role_id <= 2)
                                            <button type="button" value= 1 id="approved" class="btn btn-success response"><i class="fa fa-check">
                                            </i>Accept</button>  <button type="button" value= 0 id="declined" class="btn btn-danger response">
                                            <i class="fa fa-times"></i>Decline</button>
                                        @endif
                                    </th>
                                    
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        function doBhvSearch() {
            var search   = $("input#bhv-search").val().toLowerCase();
            var language = $("select#bhv-filter-language").val();
            var basemenu = $("select#bhv-filter-basemenu").val();
            var robot    = $("select#bhv-filter-robot").val();
            $(".bhv-row").each(function(index, elem) {
                if (search.length > 0 || language !== 'ALL' || basemenu !== 'ALL' || robot !== 'ALL') {
                    var name  = -1;
                    var descr = -1;
                    var lang  = -1;
                    var base  = -1;
                    var rbt   = -1;
                    if (search.length > 0) {
                        name = $(elem).children("td.bhv-name").text().toLowerCase().indexOf(search);
                    } else {
                        name = 0;
                    }
                    if (search.length > 0) {
                        descr = $(elem).children("td.bhv-descr").text().toLowerCase().indexOf(search);
                    } else {
                        descr = 0;
                    }
                    if (language !== 'ALL') {
                        lang = $(elem).children("td.bhv-lang").text().indexOf(language);
                    } else {
                        lang = 0;
                    }
                    if (basemenu !== 'ALL') {
                        base = $(elem).children("td.bhv-base").text().indexOf(basemenu);
                    } else {
                        base = 0;
                    }
                    if (robot !== 'ALL') {
                        rbt = $(elem).children("td.bhv-rbts").text().indexOf(robot);
                    } else {
                        rbt = 0;
                    }
                    // console.log(index + " bhv-id=" + $(elem).attr("id"));
                    if ((name > -1 || descr > -1) && lang > -1 && base > -1 && rbt > -1) {
                        $(elem).show();
                    } else {
                        $(elem).hide();
                    }
                } else {
                    $(elem).show();
                }
            });
        }
    </script>
@endsection
