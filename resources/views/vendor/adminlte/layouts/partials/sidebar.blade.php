<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">            
            <li
            @if($page == 'dashboard')
            {!! 'class="active"'!!}
            @endif
            >
                <a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>Dashboard</span></a>
            </li>
            
<!--             <li
            @if($page == 'kasir')
            {!! 'class="active"'!!}
            @endif
            >
                <a href="{{ url('transaksi/add-transaksi') }}"><i class='fa fa-money'></i> <span>Kasir</span></a>
            </li> -->

            <li
            @if($page == 'data-siswa')
            {!! 'class="active"'!!}
            @endif
            >
                <a href="{{ url('data-siswa') }}"><i class='fa fa-pencil'></i> <span>Data siswa</span></a>
            </li> 
        </ul><!-- /.sidebar-menu
    </section>
    <!-- /.sidebar -->
</aside>
