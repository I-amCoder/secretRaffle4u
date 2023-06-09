<div class="sidebar {{ sidebarVariation()['selector'] }} {{ sidebarVariation()['sidebar'] }} {{ @sidebarVariation()['overlay'] }} {{ @sidebarVariation()['opacity'] }}"
     data-background="{{getImage('assets/admin/images/sidebar/2.jpg','400x800')}}">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{route('admin.dashboard')}}" class="sidebar__main-logo"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('image')"></a>
            <a href="{{route('admin.dashboard')}}" class="sidebar__logo-shape"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" alt="@lang('image')"></a>
            <button type="button" class="navbar__expand"></button>
        </div> 
        
        @php

        $permission=DB::table('user_roles')->where('id',Auth::guard('admin')->user()->role_id)->first();
        $checkpermission=explode(',', $permission->permissions);
        @endphp


        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                @if(in_array( '1', $checkpermission))
                <li id="1" class="sidebar-menu-item {{menuActive('admin.dashboard')}}">
                    <a href="{{route('admin.dashboard')}}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard') </span>
                    </a>
                </li>
                @endif
                @if(in_array( '2', $checkpermission))
                <li id="2" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.raffle*',3)}}">
                        <i class="menu-icon las la-gamepad"></i>
                        <span class="menu-title">@lang('Raffle')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.raffle*',2)}} ">
                        <ul>
                            @if(in_array( '3', $checkpermission))
                            <li id="3" class="sidebar-menu-item {{menuActive('admin.raffle.category')}} ">
                                <a href="{{route('admin.raffle.category')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Raffle Drow Category')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '4', $checkpermission))
                            <li id="4" class="sidebar-menu-item {{menuActive('admin.raffle.winnings')}} ">
                                <a href="{{route('admin.raffle.winnings')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Raffle Winnings')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '6', $checkpermission))
                            <li id="6" class="sidebar-menu-item {{menuActive('admin.raffle.index')}} ">
                                <a href="{{route('admin.raffle.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Raffle Draw')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '7', $checkpermission))
                            <li id="7" class="sidebar-menu-item {{menuActive('admin.raffle.create')}} ">
                                <a href="{{route('admin.raffle.create')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('New Raffle Draw')</span>
                                </a>
                            </li>
                            @endif
{{--
                            <li id="2" class="sidebar-menu-item {{menuActive('admin.free_ticket.create')}} ">
                                <a href="{{route('admin.free_ticket.create')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Free Tickets')</span>
                                </a>
                            </li>
                            @if(in_array( '10', $checkpermission))

                            <li id="10" class="sidebar-menu-item {{menuActive('admin.free-ticket.index')}} ">
                                <a href="{{route('admin.free-ticket.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Raffle Game Free Ticket')</span>
                                </a>
                            </li>
                            @endif
--}}
                            <li class="sidebar-menu-item {{menuActive('admin.free-ticket.create')}} ">
                                <a href="{{route('admin.free-ticket.create')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Free Ticket Create')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if(in_array( '11', $checkpermission))
                <li id="11" class="sidebar-menu-item {{menuActive('admin.referral.index')}}">
                    <a href="{{route('admin.referral.index')}}" class="nav-link">
                        <i class="menu-icon las la-link"></i>
                        <span class="menu-title">@lang('Referral')</span>
                    </a>
                </li>
                @endif
                 @if(in_array( '12', $checkpermission))
                <li id="12" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.scratch*',3)}}">
                        <i class="menu-icon las la-gamepad"></i>
                        <span class="menu-title">@lang('Scratch Cards')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.scratch*',2)}} ">
                        <ul>
                            @if(in_array( '13', $checkpermission))
                            <li id="13" class="sidebar-menu-item {{menuActive('admin.scratch.category')}} ">
                                <a href="{{route('admin.scratch.category')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Scratch Cards Category')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '14', $checkpermission))
                            <li id="14" class="sidebar-menu-item {{menuActive('admin.scratch.index')}} ">
                                <a href="{{route('admin.scratch.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Scratch Cards')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '15', $checkpermission))
                            <li id="15" class="sidebar-menu-item {{menuActive('admin.scratch.create')}} ">
                                <a href="{{route('admin.scratch.create')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('New Scratch Cards')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '16', $checkpermission))
                            <li id="16" class="sidebar-menu-item {{menuActive('admin.paytable.index')}} ">
                                <a href="{{route('admin.paytable.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Paytables')</span>
                                </a>
                            </li> 
                            @endif

                            @if(in_array( '17', $checkpermission))
                            <li id="17" class="sidebar-menu-item {{menuActive('admin.paytable.create')}} ">
                                <a href="{{route('admin.paytable.create')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Paytabel Create')</span>
                                </a>
                            </li>
                            @endif
                            {{--  <li class="sidebar-menu-item {{menuActive('admin.free-ticket.create')}} ">
                                <a href="{{route('admin.free-ticket.create')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Free Ticket Create')</span>
                                </a>
                            </li>  --}}
                        </ul>
                    </div>
                </li>
                @endif
                
{{--
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.game*',3)}}">
                        <i class="menu-icon las la-gamepad"></i>
                        <span class="menu-title">@lang('Games')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.game*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.game.pool')}} ">
                                <a href="{{route('admin.game.pool')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pool Game')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.game.dice')}} ">
                                <a href="{{route('admin.game.dice')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Dice Game')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.game.card')}} ">
                                <a href="{{route('admin.game.card')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Card Game')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.game.nintynine')}} ">
                                <a href="{{route('admin.game.nintynine')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('0 to 99 Game')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.game.roulette')}} ">
                                <a href="{{route('admin.game.roulette')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Roulette Game')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.game.numberbuy')}} ">
                                <a href="{{route('admin.game.numberbuy')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Number Buying Game')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item {{menuActive('admin.phase.index')}}">
                    <a href="{{route('admin.phase.index')}}" class="nav-link ">
                        <i class="menu-icon las la-layer-group"></i>
                        <span class="menu-title">@lang('Game Phase')</span>
                    </a>
                </li>
--}}
                @if(in_array( '18', $checkpermission))
                <li id="18" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.win*',3)}}">
                        <i class="menu-icon las la-trophy"></i>
                        <span class="menu-title">@lang('Manage Winner')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.win*',2)}} ">
                        <ul>
                             @if(in_array( '19', $checkpermission))
                            <li id="19" class="sidebar-menu-item {{menuActive('admin.win.index')}} ">
                                <a href="{{route('admin.win.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Make Draw')</span>
                                </a>
                            </li> 
@endif
                            @if(in_array( '20', $checkpermission))
                            <li id="20" class="sidebar-menu-item {{menuActive('admin.win.winners')}} ">
                                <a href="{{route('admin.win.winners')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Winner')</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                @if(in_array( '21', $checkpermission))
                <li id="21" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.users*',3)}}">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">@lang('Manage Users')</span>

                        @if($banned_users_count > 0 || $email_unverified_users_count > 0 || $sms_unverified_users_count > 0)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.users*',2)}} ">
                        <ul>
                            @if(in_array( '22', $checkpermission))
                            <li id="22" class="sidebar-menu-item {{menuActive('admin.users.all')}} ">
                                <a href="{{route('admin.users.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Users')</span>
                                </a>
                            </li>
@endif
                            @if(in_array( '23', $checkpermission))
                            <li id="23" class="sidebar-menu-item {{menuActive('admin.users.active')}} ">
                                <a href="{{route('admin.users.active')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Active Users')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '24', $checkpermission))
                            <li id="24" class="sidebar-menu-item {{menuActive('admin.users.banned')}} ">
                                <a href="{{route('admin.users.banned')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Banned Users')</span>
                                    @if($banned_users_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$banned_users_count}}</span>
                                    @endif
                                </a>
                            </li>
@endif
                            @if(in_array( '25', $checkpermission))
                            <li id="25" class="sidebar-menu-item  {{menuActive('admin.users.email.unverified')}}">
                                <a href="{{route('admin.users.email.unverified')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Unverified')</span>

                                    @if($email_unverified_users_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$email_unverified_users_count}}</span>
                                    @endif
                                </a>
                            </li>
@endif
                            @if(in_array( '26', $checkpermission))
                            <li id="26" class="sidebar-menu-item {{menuActive('admin.users.sms.unverified')}}">
                                <a href="{{route('admin.users.sms.unverified')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('SMS Unverified')</span>
                                    @if($sms_unverified_users_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$sms_unverified_users_count}}</span>
                                    @endif
                                </a>
                            </li>
@endif
                            @if(in_array( '27', $checkpermission))
                            <li id="27" class="sidebar-menu-item {{menuActive('admin.users.with.balance')}}">
                                <a href="{{route('admin.users.with.balance')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('With Balance')</span>
                                </a>
                            </li>
@endif

                            @if(in_array( '28', $checkpermission))
                            <li id="28" class="sidebar-menu-item {{menuActive('admin.users.email.all')}}">
                                <a href="{{route('admin.users.email.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email to All')</span>
                                </a>
                            </li>
@endif
                        </ul>
                    </div>
                </li>
                @endif
{{--
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.gateway*',3)}}">
                        <i class="menu-icon las la-credit-card"></i>
                        <span class="menu-title">@lang('Payment Gateways')</span>

                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.gateway*',2)}} ">
                        <ul>

                            <li class="sidebar-menu-item {{menuActive('admin.gateway.automatic.index')}} ">
                                <a href="{{route('admin.gateway.automatic.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Automatic Gateways')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.gateway.manual.index')}} ">
                                <a href="{{route('admin.gateway.manual.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Manual Gateways')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
--}}
@if(in_array( '29', $checkpermission))
                <li id="29" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.deposit*',3)}}">
                        <i class="menu-icon las la-credit-card"></i>
                        <span class="menu-title">@lang('Deposits')</span>
                        @if(0 < $pending_deposits_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.deposit*',2)}} ">
                        <ul>
                            @if(in_array( '30', $checkpermission))
                            <li id="30" class="sidebar-menu-item {{menuActive('admin.deposit.pending')}} ">
                                <a href="{{route('admin.deposit.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Deposits')</span>
                                    @if($pending_deposits_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$pending_deposits_count}}</span>
                                    @endif
                                </a>
                            </li> 
 @endif
                            @if(in_array( '31', $checkpermission))
                            <li id="31" class="sidebar-menu-item {{menuActive('admin.deposit.approved')}} ">
                                <a href="{{route('admin.deposit.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved Deposits')</span>
                                </a>
                            </li>
 @endif
                            @if(in_array( '33', $checkpermission))
                            <li id="33" class="sidebar-menu-item {{menuActive('admin.deposit.successful')}} ">
                                <a href="{{route('admin.deposit.successful')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Successful Deposits')</span>
                                </a>
                            </li>
 @endif
                            @if(in_array( '34', $checkpermission))
                            <li id="34" class="sidebar-menu-item {{menuActive('admin.deposit.rejected')}} ">
                                <a href="{{route('admin.deposit.rejected')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Rejected Deposits')</span>
                                </a>
                            </li>
 @endif
                            @if(in_array( '35', $checkpermission))

                            <li id="35" class="sidebar-menu-item {{menuActive('admin.deposit.list')}} ">
                                <a href="{{route('admin.deposit.list')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Deposits')</span>
                                </a>
                            </li>
                             @endif
                        </ul>
                    </div>
                </li>
                 @endif
                @if(in_array( '36', $checkpermission))
                <li id="36" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.withdraw*',3)}}">
                        <i class="menu-icon la la-bank"></i>
                        <span class="menu-title">@lang('Withdrawals') </span>
                        @if(0 < $pending_withdraw_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.withdraw*',2)}} ">
                        <ul>
                            @if(in_array( '37', $checkpermission))
                            <li id="37" class="sidebar-menu-item {{menuActive('admin.withdraw.method.index')}}">
                                <a href="{{route('admin.withdraw.method.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Withdrawal Methods')</span>
                                </a>
                            </li>
                             @endif
                            @if(in_array( '38', $checkpermission))
                            <li id="38" class="sidebar-menu-item {{menuActive('admin.withdraw.pending')}} ">
                                <a href="{{route('admin.withdraw.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Log')</span>

                                    @if($pending_withdraw_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$pending_withdraw_count}}</span>
                                    @endif
                                </a>
                            </li>
                             @endif
                            @if(in_array( '39', $checkpermission))
                            <li id="39" class="sidebar-menu-item {{menuActive('admin.withdraw.approved')}} ">
                                <a href="{{route('admin.withdraw.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved Log')</span>
                                </a>
                            </li>
                             @endif
                            @if(in_array( '40', $checkpermission))
                            <li id="40" class="sidebar-menu-item {{menuActive('admin.withdraw.rejected')}} ">
                                <a href="{{route('admin.withdraw.rejected')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Rejected Log')</span>
                                </a>
                            </li>
                             @endif
                            @if(in_array( '41', $checkpermission))
                            <li id="41" class="sidebar-menu-item {{menuActive('admin.withdraw.log')}} ">
                                <a href="{{route('admin.withdraw.log')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Withdrawals Log')</span>
                                </a>
                            </li>
                             @endif

                        </ul>
                    </div>
                </li>
                 @endif
                @if(in_array( '42', $checkpermission))
                <li id="42" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.ticket*',3)}}">
                        <i class="menu-icon la la-ticket"></i>
                        <span class="menu-title">@lang('Support Ticket') </span>
                        @if(0 < $pending_ticket_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.ticket*',2)}} ">
                        <ul>
                            @if(in_array( '43', $checkpermission))
                            <li id="43" class="sidebar-menu-item {{menuActive('admin.ticket')}} ">
                                <a href="{{route('admin.ticket')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Ticket')</span>
                                </a>
                            </li>
                             @endif
                            @if(in_array( '444', $checkpermission))
                            <li id="444" class="sidebar-menu-item {{menuActive('admin.ticket.pending')}} ">
                                <a href="{{route('admin.ticket.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Ticket')</span>
                                    @if($pending_ticket_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$pending_ticket_count}}</span>
                                    @endif
                                </a>
                            </li>
                             @endif
                            @if(in_array( '44', $checkpermission))
                            <li id="44" class="sidebar-menu-item {{menuActive('admin.ticket.closed')}} ">
                                <a href="{{route('admin.ticket.closed')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Closed Ticket')</span>
                                </a>
                            </li>
                             @endif
                             @if(in_array( '45', $checkpermission))
                            <li id="45" class="sidebar-menu-item {{menuActive('admin.ticket.answered')}} ">
                                <a href="{{route('admin.ticket.answered')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Answered Ticket')</span>
                                </a>
                            </li>
                             @endif
                        </ul>
                    </div>
                </li>

                 @endif
                 @if(in_array( '46', $checkpermission))
                <li id="46" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive(['admin.report*', 'admin.referral.commissionLog', 'admin.bids'],3)}}">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Report') </span>
                    </a>
                    <div class="sidebar-submenu {{menuActive(['admin.report*', 'admin.referral.commissionLog', 'admin.bids'],2)}} ">
                        <ul>
                            @if(in_array( '47', $checkpermission))
                            <li id="47" class="sidebar-menu-item {{menuActive(['admin.report.transaction','admin.report.transaction.search'])}}">
                                <a href="{{route('admin.report.transaction')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Transaction Log')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '48', $checkpermission))
                            <li id="48" class="sidebar-menu-item {{menuActive(['admin.report.login.history','admin.report.login.ipHistory'])}}">
                                <a href="{{route('admin.report.login.history')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Login History')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '49', $checkpermission))
                            <li id="49" class="sidebar-menu-item {{menuActive('admin.report.email.history')}}">
                                <a href="{{route('admin.report.email.history')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email History')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '50', $checkpermission))
                            <li id="50" class="sidebar-menu-item {{menuActive('admin.referral.commissionLog')}} ">
                                <a href="{{route('admin.referral.commissionLog')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Commissions Log')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '51', $checkpermission))
                            <li id="51" class="sidebar-menu-item {{menuActive('admin.bids')}}">
                                <a href="{{route('admin.bids')}}" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Bids')</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                @if(in_array( '52', $checkpermission))
                <li id="52" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive(['admin.report*', 'admin.referral.commissionLog', 'admin.bids'],3)}}">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Level Pars') </span>
                    </a>
                    <div class="sidebar-submenu {{menuActive(['admin.report*', 'admin.referral.commissionLog', 'admin.bids'],2)}} ">
                        <ul>
                            @if(in_array( '53', $checkpermission))
                            <li id="53" class="sidebar-menu-item {{menuActive(['admin.report.transaction','admin.report.transaction.search'])}}">
                                <a href="{{route('admin.level.pars')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Manage')</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif



                @if(in_array( '54', $checkpermission))
                <li id="54" class="sidebar-menu-item {{menuActive('admin.phase.index')}}">
                    <a href="{{route('admin.currencies.read')}}" class="nav-link ">
                        <i class="menu-icon las la-layer-group"></i>
                        <span class="menu-title">@lang('Currencies')</span>
                    </a>
                </li>
                @endif
                @if(in_array( '55', $checkpermission))
                <li  class="sidebar__menu-header">@lang('Settings')</li>
                
                <li id="55" class="sidebar-menu-item {{menuActive('admin.setting.index')}}">
                    <a href="{{route('admin.setting.index')}}" class="nav-link">
                        <i class="menu-icon las la-life-ring"></i>
                        <span class="menu-title">@lang('General Setting')</span>
                    </a>
                </li>
                @endif
                @if(in_array( '56', $checkpermission))
                <li id="56" class="sidebar-menu-item {{menuActive('admin.setting.logo.icon')}}">
                    <a href="{{route('admin.setting.logo.icon')}}" class="nav-link">
                        <i class="menu-icon las la-images"></i>
                        <span class="menu-title">@lang('Logo & Favicon')</span>
                    </a>
                </li>
                @endif
                @if(in_array( '57', $checkpermission))
                <li id="57" class="sidebar-menu-item {{menuActive('admin.extensions.index')}}">
                    <a href="{{route('admin.extensions.index')}}" class="nav-link">
                        <i class="menu-icon las la-cogs"></i>
                        <span class="menu-title">@lang('Extensions')</span>
                    </a>
                </li>
                @endif
                @if(in_array( '58', $checkpermission))
                <li id="58" class="sidebar-menu-item  {{menuActive(['admin.language.manage','admin.language.key'])}}">
                    <a href="{{route('admin.language.manage')}}" class="nav-link"
                       data-default-url="{{ route('admin.language.manage') }}">
                        <i class="menu-icon las la-language"></i>
                        <span class="menu-title">@lang('Language') </span>
                    </a>
                </li>
                @endif
                @if(in_array( '59', $checkpermission))
                <li id="59" class="sidebar-menu-item {{menuActive('admin.seo')}}">
                    <a href="{{route('admin.seo')}}" class="nav-link">
                        <i class="menu-icon las la-globe"></i>
                        <span class="menu-title">@lang('SEO Manager')</span>
                    </a>
                </li>
                @endif
                @if(in_array( '60', $checkpermission))
                <li id="60" class="sidebar-menu-item {{menuActive('admin.seo')}}">
                    <a href="{{route('admin.rewards_page')}}" class="nav-link">
                        <i class="menu-icon las la-globe"></i>
                        <span class="menu-title">@lang('Rewards Page')</span>
                    </a>
                </li>
                @endif
                @if(in_array( '61', $checkpermission))
                <li id="61" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.email.template*',3)}}">
                        <i class="menu-icon la la-envelope-o"></i>
                        <span class="menu-title">@lang('Email Manager')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.email.template*',2)}} ">
                        <ul>
                            @if(in_array( '62', $checkpermission))
                            <li id="62" class="sidebar-menu-item {{menuActive('admin.email.template.global')}} ">
                                <a href="{{route('admin.email.template.global')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Global Template')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '63', $checkpermission))
                            <li id="63" class="sidebar-menu-item {{menuActive(['admin.email.template.index','admin.email.template.edit'])}} ">
                                <a href="{{ route('admin.email.template.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Templates')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '64', $checkpermission))
                            <li id="64" class="sidebar-menu-item {{menuActive('admin.email.template.setting')}} ">
                                <a href="{{route('admin.email.template.setting')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Configure')</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                @if(in_array( '65', $checkpermission))
                <li id="65" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.sms.template*',3)}}">
                        <i class="menu-icon la la-mobile"></i>
                        <span class="menu-title">@lang('SMS Manager')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.sms.template*',2)}} ">
                        <ul>
                            @if(in_array( '66', $checkpermission))
                            <li id="66" class="sidebar-menu-item {{menuActive('admin.sms.template.global')}} ">
                                <a href="{{route('admin.sms.template.global')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Global Setting')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '67', $checkpermission))
                            <li id="67" class="sidebar-menu-item {{menuActive('admin.sms.templates.setting')}} ">
                                <a href="{{route('admin.sms.templates.setting')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('SMS Gateways')</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array( '68', $checkpermission))
                            <li id="68" class="sidebar-menu-item {{menuActive(['admin.sms.template.index','admin.sms.template.edit'])}} ">
                                <a href="{{ route('admin.sms.template.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('SMS Templates')</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                <!-- Roles -->
                @if(in_array( '69', $checkpermission))
                 <li id="69" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.roles.permissions*',3)}}">
                        <i class="menu-icon la la-mobile"></i>
                        <span class="menu-title">@lang('Roles')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.roles.permissions*',2)}} ">
                        <ul>
                            @if(in_array( '70', $checkpermission))
                            <li id="70" class="sidebar-menu-item {{menuActive('admin.roles.permissions.index')}} ">
                                <a href="{{route('admin.roles.permissions.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('User Roles')</span>
                                </a>
                            </li>
                            @endif
                            
                        </ul>
                    </div>
                </li>
                @endif
                <!-- Roles -->
                 @if(in_array( '71', $checkpermission))
                <li id="45" class="sidebar__menu-header">@lang('Frontend Manager')</li>
               
                <li id="71" class="sidebar-menu-item {{menuActive('admin.frontend.templates')}}">
                    <a href="{{route('admin.frontend.templates')}}" class="nav-link ">
                        <i class="menu-icon la la-html5"></i>
                        <span class="menu-title">@lang('Manage Templates')</span>
                    </a>
                </li>
                @endif
                @if(in_array( '72', $checkpermission))
                <li id="72" class="sidebar-menu-item {{menuActive('admin.frontend.manage.pages')}}">
                    <a href="{{route('admin.frontend.manage.pages')}}" class="nav-link ">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Manage Pages')</span>
                    </a>
                </li>
                @endif
                @if(in_array( '73', $checkpermission))
                <li id="73" class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.frontend.sections*',3)}}">
                        <i class="menu-icon la la-html5"></i>
                        <span class="menu-title">@lang('Manage Section')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.frontend.sections*',2)}} ">
                        <ul>
                            @php
                               $lastSegment =  collect(request()->segments())->last();
                            @endphp
                            @foreach(getPageSections(true) as $k => $secs)
                                @if($secs['builder'])
                                    <li class="sidebar-menu-item  @if($lastSegment == $k) active @endif ">
                                        <a href="{{ route('admin.frontend.sections',$k) }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">{{__($secs['name'])}}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach


                        </ul>
                    </div>
                </li>
                @endif
              @if(in_array( '89', $checkpermission))
                <li id="45" class="sidebar__menu-header">@lang('Extra')</li>
                
                <li id="89" class="sidebar-menu-item {{menuActive('admin.setting.cookie')}}">
                    <a href="{{route('admin.setting.cookie')}}" class="nav-link">
                        <i class="menu-icon las la-cookie-bite"></i>
                        <span class="menu-title">@lang('GDPR Cookie')</span>
                    </a>
                </li>
                @endif
                @if(in_array( '90', $checkpermission))
                <li id="90" class="sidebar-menu-item  {{menuActive('admin.system.info')}}">
                    <a href="{{route('admin.system.info')}}" class="nav-link"
                       data-default-url="{{ route('admin.system.info') }}">
                        <i class="menu-icon las la-server"></i>
                        <span class="menu-title">@lang('System Information') </span>
                    </a>
                </li>
                @endif
                @if(in_array( '91', $checkpermission))
                <li id="91" class="sidebar-menu-item {{menuActive('admin.setting.custom.css')}}">
                    <a href="{{route('admin.setting.custom.css')}}" class="nav-link">
                        <i class="menu-icon lab la-css3-alt"></i>
                        <span class="menu-title">@lang('Custom CSS')</span>
                    </a>
                </li>
                @endif
@if(in_array( '92', $checkpermission))
                <li id="92" class="sidebar-menu-item {{menuActive('admin.setting.optimize')}}">
                    <a href="{{route('admin.setting.optimize')}}" class="nav-link">
                        <i class="menu-icon las la-broom"></i>
                        <span class="menu-title">@lang('Clear Cache')</span>
                    </a>
                </li>
                @endif
                @if(in_array( '93', $checkpermission))
                <li id="93" class="sidebar-menu-item  {{menuActive('admin.request.report')}}">
                    <a href="{{route('admin.request.report')}}" class="nav-link"
                       data-default-url="{{ route('admin.request.report') }}">
                        <i class="menu-icon las la-bug"></i>
                        <span class="menu-title">@lang('Report & Request') </span>
                    </a>
                </li>
                @endif
            </ul>
            <div class="text-center mb-3 text-uppercase">
                <span class="text--primary">{{__(systemDetails()['name'])}}</span>
                <span class="text--success">@lang('V'){{systemDetails()['version']}} </span>
            </div>
        </div>


    </div>
</div>
<!-- sidebar end -->
