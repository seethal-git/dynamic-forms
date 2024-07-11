 <!-- wrap @s -->
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                
                            </div><!-- .nk-header-brand -->
                            
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                   
                                    <li >
                                       
                                           
                                                
                                                <div class="user-info d-none d-xl-block">
                                                   
                                                    <?php $email = Session::get('email');?>
                                                    <div ><a href="{{url('logout')}}">{{$email}} - LOGOUT</a></div>
                                                </div>
                                           
                                       
                                       
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>