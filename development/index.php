<?php $title="Paras Jain"; include "header.php"; ?>
<center>
<br>
<br>
<div class="jflow-content-slider">
	<div id="slides">
		<div class="slide-wrapper">
			<div class="slide-thumbnail">
				<img src="images/imprezz.jpg" alt="photo"/>
			</div>
			<div class="slide-details">
				<h2>Virtual Buddy</h2>
				<div class="description">
					In this post we release Imprezz \UffffffffC a simple and beautiful 3-column-theme, a free WordPress theme designed by Gopal Raju from ProductiveDreams for Smashing Magazine and its readers. The theme can be used in various setting for various purposes - in magazine-blogs, but also in corporate and private blogs.
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="slide-wrapper">
			<div class="slide-thumbnail">
				<img src="images/gallery.jpg" alt="photo"/>
			</div>
			<div class="slide-details">
				<h2>Gallery Wordpress Theme</h2>
				<div class="description">
					Gallery is a beautiful, free, gallery-style Thematic child theme for WordPress, designed by Christopher Wallace especially for Smashing Magazine and its readers. It is extremely flexible and can be used as a starting point for design galleries and portfolios.
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="slide-wrapper">
			<div class="slide-thumbnail">
				<img src="images/magazeen.jpg" alt="photo"/>
			</div>
			<div class="slide-details">
				<h2>Magazeen Wordpress Theme</h2>
				<div class="description">
					Magazeen \Uffffffff\Uffffffff a free advanced Wordpress-theme in a magazine-llok created by the talented WeFunction Design Agency. This bold magazine 2-col-theme was designed with the main focus being on typography, grids and magazine-look. It was created especially for Smashing Magazine and its readers.
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="slide-wrapper">
			<div class="slide-thumbnail">
				<img src="images/vintage.jpg" alt="photo"/>
			</div>
			<div class="slide-details">
				<h2>Vintage Wordpress Theme</h2>
				<div class="description">
					The themes include full PSD-templates and can be used without any restrictions whatsoever. The themes were commissioned by Smashing Magazine exclusively for our readers and designed by Wendell Fernandes.
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="slide-wrapper">
			<div class="slide-thumbnail">
				<img src="images/blues.jpg" alt="photo"/>
			</div>
			<div class="slide-details">
				<h2>Blues Wordpress Theme</h2>
				<div class="description">
					This theme is a variation of the theme presented above; however, it tries not to focus on the vintage look but on a simple, clean, and user-friendly design. This theme was commissioned by Smashing Magazine exclusively for our readers and designed by the Dellustrations design agency.
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
		
	<div id="myController">
		<span class="jFlowPrev">Prev</span>
		<span class="jFlowControl">1</span>
		<span class="jFlowControl">2</span>
		<span class="jFlowControl">3</span>
		<span class="jFlowControl">4</span>
		<span class="jFlowControl">5</span>
		<span class="jFlowNext" id="next">Next</span>
	</div>
	<div class="clear"></div>
</div>
</center>
<br><br>
					<div id="tabs">
						<ul>
						</ul>
						<div id="tabs-1">
							<p>
								
							</p>
						</div>
					</div>
				</div>
			</td>
			<td width=200px valign=top style="vertical-align: top;top:0%;">
				<center>
					<h2><span style="font-size:20pt">Paras Jain</span><br></h2>
					<span style="font-size:14pt">parasjain {at} parasjain.com</span>
					<br><br>
					<img src="images/paras.jpg" width=150px border="2px">
					<br>
					<h3>
					Paras Jain<br>
					<a href="#" id="linkbutton">RESUME</a><br>
					<a href="#" id="linkbutton">LINKEDIN</a><br>
					<a href="#" id="linkbutton">TWITTER</a><br>
					<h3>
				</center>
			</td>
		</table>
		<script>
					function updateShouts(){
				// Assuming we have #shoutbox
				$('#next').click();
			}
			var refreshIntervalId = setInterval( "updateShouts()", 5000 );
			
			$('#myController').click(function () { 
			  clearInterval(refreshIntervalId);
			});

			
		</script>
<? include "footer.php"; ?>
