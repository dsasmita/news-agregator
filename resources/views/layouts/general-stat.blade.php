<div class="col-md-4">
	<legend>Tentang newsfeed.website</legend>
	@php
	$stat = \HelperData::countGeneralStas();
	@endphp
	<p>
		<a href="{{route('home')}}"><strong>Newsfeed.website</strong></a> adalah projek crawler data portal berita di Indonesia, yang bertujuan untuk bahan pembelajaran
		dan bahan untuk penelitian. Anda dapat berkontribusi di projek ini melalui repositori <a href="https://github.com/dsasmita/news-crawler">ini</a> sebangai tools crawler
		dan link <a href="https://github.com/dsasmita/news-agregator">ini</a> untuk view news.
	</p>
	<p>
		Saat ini situs yang telah masuk dalam list crawler adalah {!! $stat['portal'] !!}. 
		Dan akan terus berkembang situs portal lainnya. 
	</p>
	<p>
		Total posting berita yang telah di himpun hingga saat ini adalah {{number_format($stat['all'])}} posting. 
		Pada bulan ini posting yang diimpun adalah {{number_format($stat['month'])}} posting,
		dan hari ini posting berita yang dihimpun adalah {{number_format($stat['day'])}} posting.
	</p>
</div>