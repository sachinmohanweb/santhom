<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"  style="padding: 28px 30px; box-shadow: 2px 0 6px rgba(89, 102, 122, 0.1);"><a href="{{ route('admin.dashboard') }}">
            <img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo/logoname.jpg') }}" alt="" style="max-width: 100% !important;"> 
            <img class="img-fluid for-dark logo_img"
                    src="{{ asset('assets/images/logo/logoname.jpg') }}" alt="" style="max-width: 100% !important;"></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid"
                    src="{{ asset('assets/images/logo/logo.svg') }}" alt="" width="10px"></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid"
                                src="{{ asset('assets/images/logo/logo.svg') }}" alt="" width="10px"></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>

                       
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="">Affiliates</h6>
                        </div>
                    </li>
                     <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"></use>
                            </svg><span>Dashboard</span>
                        </a> 
                    </li>
                   
                    <li class="sidebar-list">
                        <label class="badge badge-light-secondary"></label><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg><span>Family & Members</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.family.list') }}">Families</a></li>
                            <li><a href="{{ route('admin.family.members.list') }}">Family Members</a></li>
                            <li><a href="{{ route('admin.family.members.import') }}">Import Family & Members</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <label class="badge badge-light-secondary"></label><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg><span>Pending Approvals</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.family.list.pending') }}">Families</a></li>
                            <li><a href="{{ route('admin.family.members.list.pending') }}">Family Members</a></li>
                        </ul>
                    </li>
                     <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{route('admin.vicar.list')}}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"> </use>
                        </svg>
                        <span>Church Personnels</span></a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{route('admin.prayergroup.list')}}">
                            <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"> </use>
                            </svg><span>Prayer Groups</span></a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{route('admin.organizations.list')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#star') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"> </use>
                            </svg><span>Organisations</span></a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Updates</h6>
                        </div>
                    </li>

                     <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{route('admin.vicarmessages.list')}}">
                        <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"> </use>
                        </svg><span>Vicar's Message</span></a>
                    </li>

                    <li class="sidebar-list">
                        <label class="badge badge-light-secondary"></label><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-knowledgebase') }}">
                                </use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"></use>
                            </svg><span>Bible Verses</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{route('admin.bibleverse.list')}}">Bible Verses List</a></li>
                            <li><a href="{{ route('admin.bibleverse.import') }}">Import Bible Verses </a></li>
                        </ul>
                    </li>

                   <li class="sidebar-list">
                        <label class="badge badge-light-secondary"></label><a class="sidebar-link sidebar-title"
                            href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg><span>Daily Digest</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.biblical.citation.list')}}">Bible Citations</a></li>
                            <li><a href="{{ route('admin.biblicalcitation.import')}}">Import Bible Citations
                            </a></li>
                            <li><a href="{{ route('admin.memories.list') }}">Memories</a></li>
                            <li><a href="{{ route('admin.daily.schedules.list') }}">Daily Schedules</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{route('admin.event.list')}}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-blog') }}"></use>

                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"> </use>
                        </svg><span>Events</span></a>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{route('admin.news_announcement.list')}}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#notification') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"> </use>
                        </svg><span>News/Announcements</span></a>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{route('admin.download.list')}}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#notification') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"> </use>
                        </svg><span>Downloads</span></a>
                    </li>
                    <li class="sidebar-list"><a     class="sidebar-link sidebar-title link-nav" href="{{route('admin.obituary.list')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#obituary') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"> </use>
                            </svg><span>Obituaries</span></a>
                        </li>
                        <li class="sidebar-list">
                            <label class="badge badge-light-secondary"></label><a class="sidebar-link sidebar-title"
                                href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#payment-card') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                                </svg><span>Contributions</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('admin.paymentdetails.list') }}">Contributions list</a></li>
                                <li><a href="{{ route('admin.contributions.import') }}">Import contributions</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list"><a     class="sidebar-link sidebar-title link-nav" 
                            href="{{route('admin.notification.list')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#notification') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"> </use>
                            </svg><span>Notifications</span></a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="#">
                            </a>
                        </li>

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i>
            </div>
        </nav>
    </div>
</div>
