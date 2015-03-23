@extends('layouts.plain')
@section('content')


<div class="homeContent">


	<h1 id="strong-title">Sequoyah</h1>
	
	<h2 id = "title-description">
		Sequoyah is a syllabary creation tool focused on providing endangered language groups the ability to generate a written 		alphabet for their spoken language.
	</h2>

</div>



<!--
		<div class="container what-is" id="what-is">
		  <div class="row text-center">
		    <div class="what-container">
		      <div class="what-column">
		        <div class="what-item">
		          <div class="what-image">
		            <i class="fa fa-rocket"></i>
		            <h3>About Sequoyah</h3>
		          </div>
		          <div class="what-content">
		            <p>Sequoyah is a syllabary creation tool focused on providing endangered language groups the ability to
			    		generate a written alphabet for their spoken language.
					</p>
		          </div>
		        </div>
		      </div>
		      <div class="what-column">
		        <div class="what-item">
		          <div class="what-image">
		            <i class="fa fa-gears"></i>
		            <h3>Feasibility</h3>
		          </div>
		          <div class="what-content">
					<p>
				    Based on the requirements of this project, it is certainly feasible. First, the requirements are the following:
					</p>
		
				    <ul>
				    <li>
						Allow the creation of a <a class='link' href='http://en.wikipedia.org/wiki/Syllabary'  						target="_blank">syllabary</a> for the language
					</li>
				    <li>
						Allow assigning custom characters to syllables of the language
					</li>
				    <li>Provide the ability to download a <a class='link' href='http://en.wikipedia.org/wiki/TrueType'  						target="_blank">TrueType font</a> of the generated written language to allow typing in the language
					</li> 
				    </ul>

				    All of these requirements can be fulfilled by creating a web application using PHP and JavaScript.
				    Creating a web application will allow for increased availability of the application and ease of use.
		          </div>
		        </div>
		      </div>
		      <div class="what-column">
		        <div class="what-item">
		          <div class="what-image">
		            <i class="fa fa-globe"></i>
		            <h3>Competition</h3>
		          </div>
		          <div class="what-content">
					<p>
				    Based on our current research, we have found that this project is very unique. We have yet to find any projects 					that
				    are designed to generate written languages based on customized syllabaries.
					</p>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>


-->






<br />
<br />

<div class="tiles">
			<div class="tile">
				<h2><a href="/docs/homestead">About Sequoyah</a></h2>
				<p>Sequoyah is a syllabary creation tool focused on providing endangered language groups the ability to
			    		generate a written alphabet for their spoken language.</p>
			</div>
			<div class="tile">
				<h2>Feasibility</h2>
					<p>
				    	Based on the requirements of this project, it is certainly feasible. First, the requirements are the 						following:
					</p>
		
				    <ul>
				    <li>
						Allow the creation of a <a class='link' href='http://en.wikipedia.org/wiki/Syllabary'  						target="_blank">syllabary</a> for the language
					</li>
				    <li>
						Allow assigning custom characters to syllables of the language
					</li>
				    <li>Provide the ability to download a <a class='link' href='http://en.wikipedia.org/wiki/TrueType'  						target="_blank">TrueType font</a> of the generated written language to allow typing in the language
					</li> 
				    </ul>

				    All of these requirements can be fulfilled by creating a web application using PHP and JavaScript.
				    Creating a web application will allow for increased availability of the application and ease of use.</p>
			</div>
			<div class="tile">
				<h2>Competition</h2>
				<p>
			    	Based on our current research, we have found that this project is very unique. We have yet to find any projects 					that
			    	are designed to generate written languages based on customized syllabaries.
				</p>
			</div>
		</div>



@stop
