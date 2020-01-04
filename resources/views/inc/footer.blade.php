<!--<footer class="bg-dark text-white mt-4 fixed-bottom">
    <div class="container-fluid py-3">
    
        <div class="col-md-3 offset-md-7 text-right align-self-end">Powered by Michele Della Mea</div>
    </div>
</footer>-->

<footer class="bg-dark text-white mt-4 fixed-bottom">
    <div class="container-fluid py-3">
        <div class="row">
            @guest
            <div class="col-sm-3 offset-sm-1 align-self-end">Guest is connected</div>
            <div class="col-sm-3 offset-sm-5 align-self-end">Powered by Michele Della Mea</div>
            @else
            <div class="col-sm-3 offset-sm-1 align-self-end">{{ Auth::user()->name . ' ' . Auth::user()->surname . ' is connected' }}</div>
            <div class="col-sm-3 offset-sm-5 align-self-end">Powered by Michele Della Mea</div>
            @endguest
        </div>
    </div>
</footer>



