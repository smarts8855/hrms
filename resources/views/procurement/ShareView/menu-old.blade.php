<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <!--Home-->
                <li>
                    <a href="{{ route('home') }}" class="waves-effect text-uppercase"> <i class="fa fa-home fa-2x"></i> Dashboard</a>
                </li> 
                <!--Contract-->
                <li>
                    <a href="javascript:;" class="has-arrow waves-effect">
                        <i class="ri-pages-line"></i>
                        <span class="text-uppercase">Contract</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('contractDetails') }}"> <i class="fa fa-pager"></i>  Create Contract</a></li>
                        <li><a href="{{ route('createContractCategory') }}"> <i class="fa fa-pager"></i>  Create Category</a></li> 
                        <li><a href="{{ route('contractReport') }}"> <i class="fa fa-pager"></i>  Contract Report</a></li>
                        <li><a href="{{ route('contractList') }}"> <i class="fa fa-pager"></i>  Contract List</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="has-arrow waves-effect">
                        <i class="ri-pages-line"></i>
                        <span class="text-uppercase">Contract Bidding</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('/add-bidding') }}"> <i class="fa fa-pager"></i>  Add Bid</a></li>
                        <li><a href="{{ url('/view-bidding') }}"> <i class="fa fa-pager"></i>  View Bids</a></li> 
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="has-arrow waves-effect">
                        <i class="ri-pages-line"></i>
                        <span class="text-uppercase">Tenders Board</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('/view-bidded-contracts') }}"> <i class="fa fa-pager"></i>  View Contract Bids</a></li>
                    </ul>
                </li>
                <!--Contractor-->
                <li>
                    <a href="javascript:;" class="has-arrow waves-effect">
                        <i class="ri-pages-line"></i>
                        <span class="text-uppercase">Contractor</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('createContractorRegistration') }}"> <i class="fa fa-user"></i>  Create Contractor</a></li>
                        <li><a href="{{ route('contractorReport') }}"> <i class="fa fa-user"></i>  Contractor Report</a></li>
                    </ul>
                </li>
                <!--Secretary-->
                <li>
                    <a href="javascript:;" class="has-arrow waves-effect">
                        <i class="ri-pages-line"></i>
                        <span class="text-uppercase">Secretary Accent</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('incoming-file') }}"> <i class="fa fa-user"></i>  Bidded Contracts</a></li>
                        
                    </ul>
                </li>
                <!-- Bank -->
                 <li>
                    <a href="javascript:;" class="has-arrow waves-effect">
                        <i class="ri-pages-line"></i>
                        <span class="text-uppercase">Confirm Project</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ (Route::has('contractList') ? Route('contractList') : '#') }}"> <i class="fa fa-pager"></i>  List of Contract</a></li>
                    </ul>
                </li>
                
                <li>
                    <a href="javascript:;" class="has-arrow waves-effect">
                        <i class="ri-pages-line"></i>
                        <span class="text-uppercase">Contract Completion</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ (Route::has('confirm-completion') ? Route('confirm-completion') : '#') }}"> <i class="fa fa-pager"></i>  Confirm Completion</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/banks">
                        <i class="ri-pages-line"></i>
                        <span class="text-uppercase">Bank</span>
                    </a>
                    
                </li>
                
                <li>
                    <a href="/procurement">
                        <i class="ri-pages-line"></i>
                        <span class="text-uppercase">Evaluation</span>
                    </a>
                    
                </li>
                
                

                <!--//================--><li><!--//=================-->
                    <a href="javascript:;" class="has-arrow waves-effect">
                        <i class="ri-pages-line"></i>
                        <span class="text-uppercase">Page Samples</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('blank') }}"> <i class="fa fa-pager"></i>  Blank Page</a></li>
                        <li><a href="{{ route('table') }}"> <i class="fa fa-pager"></i>  Table Page</a></li>
                        <li><a href="{{ route('textEditor') }}"> <i class="fa fa-pager"></i>  Text Editor Page</a></li>
                        <li><a href="{{ route('form') }}"> <i class="fa fa-pager"></i>  Form Page</a></li>
                        <li><a href="{{ route('button') }}"> <i class="fa fa-pager"></i>  Button Page</a></li>
                        <li><a href="{{ route('modal') }}"> <i class="fa fa-pager"></i>  Modal Page</a></li>
                    </ul>
                <!--//====================--></li><!--//===========-->

                <li class="menu-title">Admin</li> 



            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
