<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <div class="logo">Theta System</div>
            </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <!--Nav links for ADMIN-->
                @if(Auth::user() &&Auth::user()->role->name == 'Admin')
                    <li>
                        <a href="{{ route('report') }}">Reports</a>
                    </li>
                    <li>
                        <a href="{{ route('settings') }}">Settings</a>
                    </li>
                @endif

                <!--Nav links for AGENT-->
                @if(Auth::user() &&Auth::user()->role->name == 'Agent')
                    <li class="li-progress-bar">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $counts['percentage'] }}"
                                 aria-valuemin="0" aria-valuemax="100" style="width:{{ $counts['percentage'] }}%">
                                <span class="li-progress-bar-span">{{ $counts['completed'] }}/{{ $counts['total'] }} (%{{ $counts['percentage'] }})</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        @if($entry_link)
                            <a href="{{ route('entries', $entry_link) }}">Entries</a>
                        @else
                            <a href="#">No Entries</a>
                        @endif
                    </li>
                @endif

                @if (Auth::guest())
                    <li><a href="/login"><span class="glyphicon glyphicon-log-in"> </span> Login</a></li>
                @else
                    <li>
                        <span class="glyphicon glyphicon-user"> </span> Hello {{ Auth::user()->name }}
                    </li>
                    <li>
                        <a href="{{ url('/logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <span class="glyphicon glyphicon-log-out"> </span> Logout
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>