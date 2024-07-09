<footer>
    <?php
        use App\Models\Sponsor;
        $sponsor=Sponsor::where("rank",1)->first();
    ?>
    @if ($sponsor)
        @if ($sponsor->url)
        <button >
            <a href={{ $sponsor->url }} target="_blank"><img class="fotos" src="{{ $sponsor->logo }}" alt="Hoofdsponsor" /></a>
        </button>
        @else
        <button id="noUrl">
            <img class="fotos" src="{{ $sponsor->logo }}" alt="Hoofdsponsor" />
        </button>
        @endif
    @else
        <button>

        </button>
    @endif


    <div id="mail">
      k.f.demoedigevrienden@gmail.com
    </div>
    <nav>
      <a href="https://www.facebook.com/groups/284633908275549" target="_blank">
        <i class="fab fa-facebook"></i>
      </a>
      <a href="https://spond.com/client/groups/4B54CE00ED8F4936840114345105B38C" target="_blank">
        <img class="Spond" src="{{ asset('images/logos/spond.png') }}" alt="Spond-logo">
      </a>
      <a href="https://www.instagram.com/instaporkestdmv/" target="_blank">
        <i class="fab fa-instagram"></i>
      </a>
    </nav>

</footer>
