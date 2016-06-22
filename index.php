<?php
	//Disable debug mode by default
	$debug = false;
	
	//Force debug mode. Set it to true to always force debug mode.
	$forceDebug = false;
	
	//check if URL have debug parameter
	if (isset($_GET['debug']) || $forceDebug) {
		$debug = true;
	}
?><!DOCTYPE html>
<html lang="en">
<head>
	<!-- Helioviewer.org 3.0 (rev. 700), 2012/04/02 -->
	<title><?=($debug ? '[DEBUG]' : '')?> Helioviewer.org - Solar and heliospheric image visualization tool</title>
	<meta charset="utf-8" />
	<meta name="description" content="Helioviewer.org - Solar and heliospheric image visualization tool" />
	<meta name="keywords" content="Helioviewer, JPEG 2000, JP2, sun, solar, heliosphere, solar physics, viewer, visualization, space, astronomy, SOHO, SDO, STEREO, AIA, HMI, EUVI, COR, EIT, LASCO, SDO, MDI, coronagraph, " />
	<!--if ($this->config["disable_cache"])-->
	<!--<meta http-equiv="Cache-Control" content="No-Cache" />-->

	<link rel="shortcut icon" type="image/png" href="/favicon.png"/>

	<!-- Blog RSS Feed -->
	<link rel="alternate" type="application/rss+xml" title="The Helioviewer Project Blog RSS Feed" href="http://blog.helioviewer.org/feed/" />
	<link rel="alternate" type="application/atom+xml" title="The Helioviewer Project Blog Atom Feed" href="http://blog.helioviewer.org/feed/atom/" />

	<!--OpenGraph Metadata-->
	<meta property="og:title" content="Helioviewer.org" />
	<!--OpenGraph Metadata Image-->
	<meta id="fb-og-image" property="og:description" content="Solar and heliospheric image visualization tool." />
	<meta id="fb-og-image" property="og:image" content="http://helioviewer.org/resources/images/logos/hvlogo1s_transparent.png" />
	
	<!-- Library CSS -->
	<link rel="stylesheet" href="resources/lib/yui-2.8.2r1/reset-fonts.css" />
	<link rel="stylesheet" href="resources/lib/jquery.ui-1.8/css/dot-luv-modified/jquery-ui-1.8.12.custom.css" />	
	<link rel="stylesheet" href="resources/lib/jquery.jgrowl/jquery.jgrowl.css" />
	<link rel="stylesheet" href="resources/lib/jquery.qTip2/jquery.qtip.min.css" />
	<link rel="stylesheet" href="resources/lib/jquery.imgareaselect-0.9.8/css/imgareaselect-default.css" />
	<link rel="stylesheet" href="resources/lib/DatetimePicker/jquery.datetimepicker.css"/ >
	<link rel="stylesheet" href="resources/lib/period_picker.2.7.8.pro/build/jquery.periodpicker.min.css"/ >
	<link rel="stylesheet" href="resources/lib/period_picker.2.7.8.pro/build/jquery.timepicker.css"/ >
	<link rel="stylesheet" href="resources/lib/boneVojage/bonevojage.css">

	<!-- jQuery UI Theme Modifications -->
	<link rel="stylesheet" href="resources/css/dot-luv.css">
	
	<!-- Helioviewer CSS -->
	<?php
	if ($debug){
	?>
		<link rel="stylesheet" href="resources/css/helioviewer-base.css" />
		<link rel="stylesheet" href="resources/css/zoom-control.css" />
		<link rel="stylesheet" href="resources/css/helioviewer-web.css" />
		<link rel="stylesheet" href="resources/css/layout.css" />
		<link rel="stylesheet" href="resources/css/accordions.css" />
		<link rel="stylesheet" href="resources/css/dialogs.css" />
		<link rel="stylesheet" href="resources/css/events.css" />
		<link rel="stylesheet" href="resources/css/media-manager.css" />
		<link rel="stylesheet" href="resources/css/timeline.css" />
		<link rel="stylesheet" href="resources/css/timenav.css" />
		<link rel="stylesheet" href="resources/css/video-gallery.css" />
		<link rel="stylesheet" href="resources/css/youtube.css" />
		<link rel="stylesheet" href="resources/css/font-awesome.min.css" />
	<?php
	} else {
	?>
		<link rel="stylesheet" href="resources/compressed/helioviewer.min.css?v=<?=filemtime('resources/compressed/helioviewer.min.css')?>" />
		<!-- Google Analytics -->
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-20263053-1']);
			_gaq.push(['_trackPageview']);
			_gaq.push(['_trackPageLoadTime']);
	
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			}) ();
		</script>
	<?php
	}	
	?>
	
	
	
</head>
<body>
	<div class="user-select-none" style="width: 100%; margin: 0; padding: 0; text-align: center; z-index: 9;">
		<!-- Image area select tool -->
		<div id='image-area-select-buttons'>
	
			<div style="margin: 0 auto; width: 20em;">
				<div id='cancel-selecting-image' class='text-btn'>
					<span class='fa fa-times-circle fa-fw'></span>
					<span>Cancel</span>
				</div>
				<div id='done-selecting-image' class='text-btn'>
					<span class='fa fa-check-circle fa-fw'></span>
					<span>Confirm Selection</span>
				</div>
			</div>
	
		</div>
	</div>
	
	
	<div style="width: 100%; height: 100%; margin: 0; padding: 0;">
	
		<div id="hv-header" class="user-select-none">
	
			<div id="loading">
				<span>
					<span>Loading Data</span>
					<span class="fa fa-circle-o-notch fa-spin"></span>
				</span>
			</div>
	
			<div id="logo">
				<h1>
					<span><a class="logo-icon fa fa-sun-o fa-fw" href="" title="The Open-Source Solar and Heliospheric Data Browser"></a><a class="logo-text" href="" title="The Open-Source Solar and Heliospheric Data Browser">Helioviewer.org</a></span>
				</h1>
			</div>
	
			<div id="zoom">
	
				<!--  Zoom Controls -->
				<div id="zoomControls" style="display: none;">
					<div id="zoomControlZoomIn" title="Zoom in." style="display: none;">+</div>
					<div id="zoomSliderContainer" style="display: none;">
						<div id="zoomControlSlider" style="display: none;"></div>
					</div>
					<div id="zoomControlZoomOut" title="Zoom out." style="display: none;">-</div>
				</div>
	
				<div id="center-button" class="viewport-action fa fa-crosshairs" title="Center the Sun in the Viewport"></div>
	
				<div id="zoom-out-button" class="viewport-action fa fa-search-minus" title="Zoom Out"></div>
	
				<div id="zoom-in-button" class="viewport-action fa fa-search-plus" title="Zoom In"></div>
	
			</div>
	
			<div id="menus">
	
				<div class="left">
	
					<div id="news-button" class="fa fa-rss fa-fw qtip-left social-button" title="Helioviewer Project Announcements."></div>
	
					<a id="youtube-button" class="fa fa-youtube fa-fw qtip-left social-button header-tab" title="View Helioviewer Movies Shared to YouTube."></a>
	
					<div id="movies-button" class="fa fa-file-video-o fa-fw qtip-left social-button" title="Create a Helioviewer Movie."></div>
	
					<a id="screenshots-button" class="fa fa-file-picture-o fa-fw qtip-left social-button" title="Download a screenshot of the current Helioviewer Viewport."></a>
	
					<a id="data-button" class="fa fa-file-code-o fa-fw qtip-left social-button" title="Request Science Data Download from External Partners."></a>
	
					<div id="share-button" class="fa fa-share-square-o fa-fw qtip-left social-button" title="Share the current viewport on social media."></div>
				</div>
	
				<div class="right" style="margin-right: 0.5em;">
					<div id="help-button" class="fa fa-question fa-fw qtip-left" href="" style="margin-left: 0.5em;" title="Get Help with Helioviewer."></div>
	
					<div id="settings-button" class="fa fa-cog fa-fw qtip-left" title="Edit Settings &amp; Defaults."></div>
				</div>
	
			</div>
	
	
			<div id="scale">
				
				<div id="earth-button" class="viewport-action segmented-left fa fa-globe" title="Toggle Earth-Scale Indicator."></div><div id="scalebar-button" class="viewport-action segmented-right fa fa-arrows-h" style="border-left: 0;" title="Toggle Length scale indicator."></div>
	
			</div>
	
			<!-- Mouse coordinates display -->
			<div id="mouse-coords-box">
				<div id="mouse-coords">
					<div id="mouse-coords-x"></div>
					<div id="mouse-coords-y"></div>
				</div>
				<div id="mouse-cartesian" style="margin-top:4px;" class="viewport-action segmented-left fa fa-cube" title="Toggle Mouse Coordinates (Cartesian)"></div><div id="mouse-polar" class="viewport-action segmented-right fa fa-dot-circle-o" style="border-left: 0;margin-top:4px;" title="Toggle Mouse Coordinates (Polar)"></div>
			</div>
	
		</div>
	
		<div id="hv-drawer-left" class="user-select-none">
			<div class="drawer-contents">
				<div id="accordion-date" class="accordion">
	
					<div class="header">
	
						<div class="disclosure-triangle closed">►</div>
						<h1>Observation Date</h1>
						<div class="right fa fa-question-circle contextual-help" style="margin-right: 15px;" title="
	Changing the 'Observation Date' will update the Viewport with data matching the new date and time.<br /><br />
	
	Use the 'Jump' controls to browse forward and backward in time by a regular interval.<br /><br />
	
	Note that when an image is not available for the exact date and time you selected, the closest available match will be displayed instead.<br />
						">
						</div>
					</div>
	
					<div class="content">
						<div class="section">
							<div id="observation-controls" class="row">
								<div class="label">Date:</div>
								<div class="field">
									<input type="text" id="date" name="date" value="" pattern="[\d]{4}/[\d]{2}/[\d]{2}" maxlength="10" class="hasDatepicker"/>
	
									<input id="time" name="time" value="" type="text" maxlength="8" pattern="[\d]{2}:[\d]{2}:[\d]{2}"/>
	
									<div class="suffix">UTC</div>
	
									<div id="timeNowBtn" class="fa fa-clock-o right" style="padding-top: 0.4em; font-size: 1em;" title="Jump to the most recent available image's for the currently loaded layer(s).">
										<span class="ui-icon-label">NEWEST</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="label">Jump:</div>
								<div class="field">
	
									<select id="timestep-select" name="time-step"></select>
	
									<div id="timeBackBtn" class="inline fa fa-arrow-circle-left" style="font-size: 1.5em;" title="Jump Backward in Time."></div>
									<div id="timeForwardBtn" class="inline fa fa-arrow-circle-right" style="font-size: 1.5em;" title="Jump Forward in Time."></div>
								</div>
							</div>
						</div>
					</div>
	
				</div>
	
				<div id="accordion-images" class="accordion">
					<div class="header">
						<div class="disclosure-triangle closed">►</div>
						<h1>Images</h1>
						<div class="right fa fa-question-circle contextual-help" style="margin-right: 15px;" title="Up to five (5) independent image layers may be viewed simultaneously."></div>
						<div class="accordion-header">
							<a href="#" id="add-new-tile-layer-btn" class="text-button" title="Click to add an image data layer to the Viewport."><span class="fa fa-plus-circle"></span> Add Layer</a>
						</div>
					</div>
					<div class="content">
						<div id="tileLayerAccordion">
							<div id="TileLayerAccordion-Container"></div>
						</div>
					</div>
				</div>
	
				<div id="accordion-events" class="accordion">
					<div class="header">
						<div class="disclosure-triangle closed">►</div>
						<h1>Features and Events</h1>
						<div class="right fa fa-question-circle contextual-help" style="margin-right: 15px;" title="Solar feature and event annotations such as marker pins, extended region polygons, and metadata."></div>
					</div>
					<div class="content">
						<div id="eventLayerAccordion">
							<div id="EventLayerAccordion-Container"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="hv-drawer-tab-left" class="drawer-tab drawer-tab-left user-select-none">Data Sources</div>
	
	
		<div id="hv-drawer-news" class="hv-drawer-right user-select-none">
			<div class="drawer-contents">
	
				<div id="accordion-news" class="accordion">
					<div class="header">
						<div class="disclosure-triangle-alway-open opened">►</div>
						<h1>Helioviewer Project News</h1>
						<div class="right fa fa-question-circle contextual-help qtip-left" title="Helioviewer Project news and tweets."></div>
					</div>
					<div class="content" style="display:block;">
						<div class="section">
							<div id="social-panel" class="ui-widget ui-widget-content ui-corner-all"></div>
						</div>
					</div>
				</div>
	
			</div>
		</div>
	
	
		<div id="hv-drawer-youtube" class="hv-drawer-right user-select-none">
			<div class="drawer-contents">
	
				<div id="accordion-youtube" class="accordion">
					<div class="header">
						<div class="disclosure-triangle-alway-open opened">►</div>
						<h1>Movies Shared to YouTube</h1>
						<div class="right fa fa-question-circle contextual-help qtip-left" title="View YouTube movies generated by users of Helioviewer."></div>
					</div>
					<div class="content" style="display:block;">
						<div class="section">
							<!-- User-Submitted Videos -->
							<div id="user-video-gallery" class="ui-widget ui-widget-content ui-corner-all">
								<div id="user-video-gallery-main">
									<div id="user-video-gallery-spinner"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	
		<div id="hv-drawer-movies" class="hv-drawer-right user-select-none">
			<div class="drawer-contents">
	
				<div id="accordion-movies" class="accordion">
					<div class="header">
						<div class="disclosure-triangle-alway-open opened">►</div>
						<h1>Generate a Movie</h1>
						<div class="right fa fa-question-circle contextual-help qtip-left" title="Generate a custom move from up to three (3) image layers plus solar feature and event marker pins, labels, and extended region polygons."></div>
					</div>
					<div class="content" style="display:block;">
						<div class="section">
	
							<!-- Movie Manager -->
							<div id='movie-manager-container' class='media-manager-container'>
								<div id='movie-manager-build-btns' class='media-manager-build-btns'>
									<div style="width: 70%; margin: 0 auto;">
										<div id='movie-manager-full-viewport' class='text-btn qtip-left' title='Create a movie using the entire viewport.'>
											<span class='fa fa-arrows-alt fa-fw'></span>
											<span style='line-height: 1.6em'>Full Viewport</span>
										</div>
										<div id='movie-manager-select-area' class='text-btn qtip-left' style='float:right;' title='Create a movie of a sub-region of the viewport.'>
											<span class='fa fa-crop fa-fw'></span>
											<span style='line-height: 1.6em'>Select Area</span>
										</div>
									</div>
								</div>
								<div id='movie-history-title'>
									Movie History:
									<div id='movie-clear-history-button' class='text-btn qtip-left' style='float:right;' title='Remove all movies from the history.'>
										<span style='font-weight: 200;'>clear history</span>
										<span class='fa fa-trash-o'></span>
									</div>
								</div>
								<div id='movie-history'></div>
							</div>
	
							<!-- Movie Settings -->
							<div id='movie-settings-container' class='media-manager-container'>
								<b>Movie Settings:</b>
	
								<div id='movie-settings-btns' style='float:right;'>
									<span id='movie-settings-toggle-help' style='display:inline-block;' class='fa fa-help qtip-left' title='Movie settings help'></span>
								</div>
	
								<!-- Begin movie settings -->
								<div id='movie-settings-form-container'>
								<form id='movie-settings-form'>
	
								<!-- Movie duration -->
								<fieldset style='padding: 0px; margin: 5px 0px 8px'>
									<label for='movie-duration' style='margin-right: 5px; font-style: italic;'>Duration</label>
									<select id='movie-duration' name='movie-duration'>
										<option value='3600'>1 hour</option>
										<option value='10800'>3 hours</option>
										<option value='21600'>6 hours</option>
										<option value='43200'>12 hours</option>
										<option value='86400'>1 day</option>
										<option value='172800'>2 days</option>
										<option value='604800'>1 week</option>
										<option value='2419200'>28 days</option>
									</select>
								</fieldset>
	
								<!-- Advanced movie settings -->
								<div id='movie-settings-advanced'>
	
									<!-- Movie Speed -->
									<fieldset id='movie-settings-speed'>
										<legend>Speed</legend>
										<div style='padding:10px;'>
											<input type="radio" name="speed-method" id="speed-method-f" value="framerate" checked="checked" />
											<label for="speed-method-f" style='width: 62px;'>Frames/Sec</label>
											<input id='frame-rate' maxlength='2' size='3' type="text" name="framerate" min="1" max="30" value="15" pattern='^(0?[1-9]|[1-2][0-9]|30)$' />(1-30)<br />
	
											<input type="radio" name="speed-method" id="speed-method-l" value="length" />
											<label for="speed-method-l" style='width: 62px;'>Length (s)</label>
											<input id='movie-length' maxlength='3' size='3' type="text" name="movie-length" min="5" max="300" value="20" pattern='^(0{0,2}[5-9]|0?[1-9][0-9]|100)$' disabled="disabled" />(5-100)<br />
										</div>
									</fieldset>
								</div>
	
								<!-- Movie request submit button -->
								<div id='movie-settings-submit'>
									<input type="button" id='movie-settings-cancel-btn' value="Cancel" />
									<input type="submit" id='movie-settings-submit-btn' value="Ok" />
								</div>
	
								</form>
								</div>
	
								<!-- Movie settings help -->
								<div id='movie-settings-help' style='display:none'>
									<b>Duration</b><br /><br />
									<p>The duration of time that the movie should span, centered about your current observation time.</p><br />
	
									<b>Speed</b><br /><br />
									<p>Movie speed can be controlled either by specifying a desired frame-rate (the number of frames displayed each second) or a length in seconds.</p><br />
								</div>
	
								<!-- Movie settings validation console -->
								<div id='movie-settings-validation-console' style='display:none; text-align: center; margin: 7px 1px 0px; padding: 0.5em; border: 1px solid #fa5f4d; color: #333; background: #fa8072;' class='ui-corner-all'>
	
								</div>
							</div>
	
						</div>
					</div>
				</div>
	
			</div>
		</div>
	
	
		<div id="hv-drawer-screenshots" class="hv-drawer-right user-select-none">
			<div class="drawer-contents">
	
				<div id="accordion-screenshots" class="accordion">
					<div class="header">
						<div class="disclosure-triangle-alway-open opened">►</div>
						<h1>Generate a Screenshot</h1>
						<div class="right fa fa-question-circle contextual-help qtip-left" title="Download a custom screenshot matching the state of your Helioviewer session, minus the user-interface."></div>
					</div>
					<div class="content" style="display:block;">
	
						<!-- Screenshot Manager -->
						<div id='screenshot-manager-container' class='media-manager-container'>
	
							<div class="section">
								<div id='screenshot-manager-build-btns' class='media-manager-build-btns'>
									<div style="width: 70%; margin: 0 auto;">
										<div id='screenshot-manager-full-viewport' class='text-btn qtip-left' title='Create a screenshot using the entire viewport.'>
											<span class='fa fa-arrows-alt fa-fw'></span>
											<span style='line-height: 1.6em'>Full Viewport</span>
										</div>
										<div id='screenshot-manager-select-area' class='text-btn qtip-left' style='float:right;' title='Create a screenshot of a sub-region of the viewport.'>
											<span class='fa fa-crop fa-fw'></span>
											<span style='line-height: 1.6em'>Select Area</span>
										</div>
									</div>
								</div>
	
								<div id='screenshot-history-title'>
									Screenshot History:
									<div id='screenshot-clear-history-button' class='text-btn qtip-left' style='float:right;' title='Remove all screenshots from the history.'>
										<span style='font-weight: 200;'>clear history</span>
										<span class='fa fa-trash-o'></span>
									</div>
								</div>
								<div id='screenshot-history'></div>
							</div>
	
						</div>
	
					</div>
				</div>
	
			</div>
		</div>
	
	
		<div id="hv-drawer-data" class="hv-drawer-right user-select-none">
			<div class="drawer-contents">
	
				<div id="accordion-vso" class="accordion">
					<div class="header">
						<div class="disclosure-triangle closed">►</div>
						<h1>Virtual Solar Observatory</h1>
						<div class="right fa fa-question-circle contextual-help qtip-left" title="Request science data downloads via the Virtual Solar Observatory (VSO)."></div>
					</div>
					<div class="content">
						<div class="section">
							<h1>Request Viewport Images from VSO</h1>
							<div id="vso-links"></div>
						</div>
	
						<div class="section">
							<h1>Request Image Sequence from VSO</h1>
							<div>
								<div class="row">
									<div class="label inactive">Start Date:</div>
									<div class="field">
										<input type="text" id="vso-start-date" name="vso-start-date" value="" pattern="[\d]{4}/[\d]{2}/[\d]{2}" maxlength="10" class="hasDatepicker" disabled />
	
										<input id="vso-start-time" name="vso-start-time" value="" type="text" maxlength="8" pattern="[\d]{2}:[\d]{2}:[\d]{2}" disabled />
	
										<div class="suffix">UTC</div>
									</div>
								</div>
	
								<div class="row">
									<div class="label inactive">End Date:</div>
									<div class="field">
										<input type="text" id="vso-end-date" name="vso-end-date" value="" pattern="[\d]{4}/[\d]{2}/[\d]{2}" maxlength="10" class="hasDatepicker" disabled />
	
										<input id="vso-end-time" name="vso-end-time" value="" type="text" maxlength="8" pattern="[\d]{2}:[\d]{2}:[\d]{2}" disabled />
	
										<div class="suffix inactive">UTC</div></div>
								</div>
	
								<div class="row">
									<div id="vso-previews"></div>
								</div>
	
								<div class="row">
									<div id="vso-buttons"  class="buttons">
										<div id="vso-sunpy" style="display:none;" class="text-button fa fa-download inactive qtip-left" title="Download a Python SunPy script that will request from the Virtual Solar Observatory the data set specified above."> SunPy Script</div>
										<div id="vso-ssw" class="text-button fa fa-download inactive qtip-left" title="Download an IDL SolarSoft script that will request from the Virtual Solar Observatory the data set specified above."> SSW Script</div>
										<a id="vso-www" class="text-button fa fa-external-link-square inactive qtip-left" title="Launch a Virtual Solar Observatory web page that will request the data set specified above." target="_blank"> VSO Website</a>
									</div>
								</div>
	
							</div>
						</div>
					</div>
				</div>
	
				<div id="accordion-sdo" class="accordion">
					<div class="header">
						<div class="disclosure-triangle closed">►</div>
						<h1>SDO AIA/HMI Cut-out Service</h1>
						<div class="right fa fa-question-circle contextual-help qtip-left" title="Request AIA or HMI sub-field images."></div>
					</div>
					<div class="content">
						<div class="section">
							<h1>Request Image Sequence from Cut-out Service</h1>
							<div style="padding-bottom:50px">
								<div class="row">
									<div class="label inactive">Start Date:</div>
									<div class="field">
										<input type="text" id="sdo-start-date" name="sdo-start-date" value="" pattern="[\d]{4}/[\d]{2}/[\d]{2}" maxlength="10" class="hasDatepicker" disabled />
	
										<input id="sdo-start-time" name="sdo-start-time" value="" type="text" maxlength="8" pattern="[\d]{2}:[\d]{2}:[\d]{2}" disabled />
	
										<div class="suffix inactive">UTC</div>
									</div>
								</div>
	
								<div class="row">
									<div class="label inactive">End Date:</div>
									<div class="field">
										<input type="text" id="sdo-end-date" name="sdo-end-date" value="" pattern="[\d]{4}/[\d]{2}/[\d]{2}" maxlength="10" class="hasDatepicker" disabled />
	
										<input id="sdo-end-time" name="sdo-end-time" value="" type="text" maxlength="8" pattern="[\d]{2}:[\d]{2}:[\d]{2}" disabled />
	
										<div class="suffix inactive">UTC</div></div>
								</div>
	
								<br />
	
	
								<div class="row">
									<div style="font-size: 1.3em;">
										<div class="media-manager-build-btns buttons" style="width: 70%; margin: 0 auto;">
											<div id='sdo-full-viewport' class='text-btn qtip-left selected inactive' title='Entire viewport.'>
												<span class='fa fa-arrows-alt fa-fw'></span>
												<span style='line-height: 1.6em'>Full Viewport</span>
											</div>
											<div id='sdo-select-area' class='text-btn qtip-left inactive' style='float:right;' title='Sub-field'>
												<span class='fa fa-crop fa-fw'></span>
												<span style='line-height: 1.6em'>Select Area</span>
											</div>
										</div>
									</div>
								</div>
	
	
								<div class="row">
									<div class="label inactive">Center (x,y):</div>
									<div class="field">
										<input type="text" id="sdo-center-x" name="sdo-center-x" value="0" maxlength="6" disabled />
										<input id="sdo-center-y" name="sdo-center-y" value="0" type="text" maxlength="6" disabled />
										<div class="suffix inactive">arcsec</div>
									</div>
								</div>
	
								<div class="row">
									<div class="label inactive">Width:</div>
									<div class="field" style="text-align: left;">
										<input type="text" id="sdo-width" name="sdo-width" value="2000" maxlength="6" disabled />
										<div class="suffix inactive">arcsec</div>
									</div>
								</div>
	
								<div class="row">
									<div class="label inactive">Height:</div>
									<div class="field">
										<input type="text" id="sdo-height" name="sdo-height" value="2000" maxlength="6" disabled />
										<div class="suffix inactive">arcsec</div>
									</div>
								</div>
	
								<div class="row">
									<div id="sdo-previews"></div>
								</div>
	
								<div class="row">
									<div id="sdo-buttons" class="buttons">
										<div id="sdo-ssw" class="text-button fa fa-download inactive qtip-left" title="Download an IDL SolarSoft script that will request from the SDO Cut-out Service the data set specified above."> SSW Script</div>
										<a id="sdo-www" class="text-button fa fa-external-link-square qtip-left" title="Launch a SDO Cut-out Service web page that will request the data set specified above." target="_blank"> SDO Cut-out Service Website</a>
									</div>
								</div>
	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	
	
		<div id="hv-drawer-share" class="hv-drawer-right user-select-none">
			<div class="drawer-contents">
	
				<div id="accordion-link" class="accordion">
					<div class="header">
						<div class="disclosure-triangle-alway-open opened">►</div>
						<h1>Share Link to Current Viewport</h1>
						<div class="right fa fa-question-circle contextual-help qtip-left" title="Share Link to Current Viewport"></div>
					</div>
					<div class="content" style="display:block;">
						<div class="section">
							<div id="helioviewer-url-box" style="font-size: 1em;">
								<span id="helioviewer-url-box-msg"></span>
								<form style="margin-top: 5px; text-align: center;">
									<input type="text" class="helioviewer-url-input-box" style="width:98%;" value="http://helioviewer.org" />
									<label for="helioviewer-url-shorten">Shorten with bit.ly? </label>
									<input type="checkbox" class="helioviewer-url-shorten" />
									<input type="hidden" class="helioviewer-short-url" value="" />
									<input type="hidden" class="helioviewer-long-url" value="" />
								</form>
							</div>
	
							<br />
	
							<div>
								<div style="width: 65%; height: 40px; margin: 0 auto; font-size: 1.5em;">
									<div id='share-copy-link' class='text-btn qtip-left' title='Copy Link'>
										<span class='fa fa-copy fa-fw'></span>
										<span style='line-height: 1.6em'>Copy Link</span>
									</div>
									<div id='share-email-link' class='text-btn qtip-left' style='float:right;' title='Email Link'>
										<span class='fa fa-envelope fa-fw'></span>
										<span style='line-height: 1.6em'>Email Link</span>
									</div>
								</div>
							</div>
	
						</div>
					</div>
				</div>
	
				<div id="accordion-social" class="accordion">
					<div class="header">
						<div class="disclosure-triangle-alway-open opened">►</div>
						<h1>Share to Social Networks</h1>
						<div class="right fa fa-question-circle contextual-help qtip-left" title="Share Link to Current Viewport"></div>
					</div>
					<div class="content" style="display:block;">
						<div class="section">
							<div id="social-panel">
	
								<div id='twitter' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='share-twitter-link' class='text-btn qtip-left' style="width: 90%;border:none;" title='Tweet Screenshot'>
											<span class='fa fa-twitter-square fa-fw'></span>
											<span style='line-height: 1.6em'>Tweet Screenshot</span>
										</div>
									</div>
								</div>
	
								<div id='facebook' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='share-facebook-link' class='text-btn qtip-left color-facebook' style="width: 90%;border:none;" title='Share Screenshot with Facebook'>
											<span class='fa fa-facebook-square fa-fw'></span>
											<span style='line-height: 1.6em'>Share Screenshot with Facebook</span>
										</div>
									</div>
								</div>
	
								<div id='google' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='share-google-link' class='text-btn qtip-left color-google' style="width: 90%;border:none;" title='Share Screenshot with Google+'>
											<span class='fa fa-google-plus-square fa-fw'></span>
											<span style='line-height: 1.6em'>Share Screenshot with Google+</span>
										</div>
									</div>
								</div>
	
								<div id='pinterest' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='share-pinterest-link' class='text-btn qtip-left' style="width: 90%;border:none;" title='Pin Screenshot'>
											<span class='fa fa-pinterest-square fa-fw'></span>
											<span style='line-height: 1.6em'>Pin Screenshot</span>
										</div>
									</div>
								</div>
	
	
							</div>
						</div>
					</div>
				</div>
	
			</div>
		</div>
	
	
	
		<div id="hv-drawer-help" class="hv-drawer-right user-select-none">
			<div class="drawer-contents">
	
				<div id="accordion-help-links" class="accordion">
					<div class="header">
						<div class="disclosure-triangle-alway-open opened">►</div>
						<h1>The Helioviewer Project</h1>
						<div class="right fa fa-question-circle contextual-help qtip-left" title="About Helioviewer.org"></div>
					</div>
					<div class="content" style="display:block;">
						<div class="section">
							<div id="help-links-panel" class="">
	
								<div id='' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='help-links-tutorial' onclick="startTutorial();" class='text-btn qtip-left' style="width: 90%;border:none;" title="Interactive Tutorial" rel="/dialogs/about.php">
											<span class='fa fa-compass fa-fw'></span>
											<span style='line-height: 1.6em'>Interactive Tutorial</span>
										</div>
									</div>
								</div>
	
								<div id='' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='help-links-legacy' onclick="window.open('http://legacy.helioviewer.org','_blank');" class='text-btn qtip-left' style="width: 90%;border:none;" title="Legacy Helioviewer.org" >
											<span class='fa fa-certificate fa-fw'></span>
											<span style='line-height: 1.6em'>Legacy Helioviewer.org</span>
										</div>
									</div>
								</div>
	
								<div id='' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='help-links-about' class='text-btn qtip-left' style="width: 90%;border:none;" title="About Helioviewer.org" rel="/dialogs/about.php">
											<span class='fa fa-question-circle fa-fw'></span>
											<span style='line-height: 1.6em'>About Helioviewer.org</span>
										</div>
									</div>
								</div>
	
								<div id='' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='help-links-guide' class='text-btn qtip-left' style="width: 90%;border:none;" title="User's Guide">
											<span class='fa fa-bookmark-o fa-fw'></span>
											<span style='line-height: 1.6em'>User's Guide</span>
										</div>
									</div>
								</div>
	
								<div id='' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='help-links-glossary' class='text-btn qtip-left color-facebook' style="width: 90%;border:none;" title='Visual Glossary' rel="/dialogs/glossary.html">
											<span class='fa fa-key fa-fw'></span>
											<span style='line-height: 1.6em'>Visual Glossary</span>
										</div>
									</div>
								</div>
	
								<div id='' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='help-links-shortcuts' class='text-btn qtip-left' style="width: 90%;border:none;" title='Keyboard Shortcuts' rel="/dialogs/usage.php">
											<span class='fa fa-keyboard-o fa-fw'></span>
											<span style='line-height: 1.6em'>Keyboard Shortcuts</span>
										</div>
									</div>
								</div>
	
								<div id='' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='help-links-documentation' class='text-btn qtip-left' style="width: 90%;border:none;" title='Documentation'>
											<span class='fa fa-book fa-fw'></span>
											<span style='line-height: 1.6em'>Documentation</span>
										</div>
									</div>
								</div>
	
								<div id='' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='help-links-api-documentation' class='text-btn qtip-left' style="width: 90%;border:none;" title='Public API Documentation'>
											<span class='fa fa-code fa-fw'></span>
											<span style='line-height: 1.6em'>Public API Documentation</span>
										</div>
									</div>
								</div>
	
								<div id='' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='help-links-blog' class='text-btn qtip-left' style="width: 90%;border:none;" title='Blog'>
											<span class='fa fa-rss fa-fw'></span>
											<span style='line-height: 1.6em'>Blog</span>
										</div>
									</div>
								</div>
	
								<div id='' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='help-links-jhelioviewer' class='text-btn qtip-left' style="width: 90%;border:none;" title='JHelioviewer'>
											<span class='fa fa-sun-o fa-fw'></span>
											<span style='line-height: 1.6em'>JHelioviewer</span>
										</div>
									</div>
								</div>
	
								<div id='' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='help-links-contact' class='text-btn qtip-left' style="width: 90%;border:none;" title='Contact'>
											<span class='fa fa-envelope fa-fw'></span>
											<span style='line-height: 1.6em'>Contact</span>
										</div>
									</div>
								</div>
	
								<div id='' class='social-btns'>
									<div style="font-size: 1.5em;">
										<div id='help-links-github' class='text-btn qtip-left' style="width: 90%;border:none;" title='Report problem'>
											<span class='fa fa-exclamation fa-fw'></span>
											<span style='line-height: 1.6em'>Report problem</span>
										</div>
									</div>
								</div>
	
								<br />
	
	
							</div>
						</div>
					</div>
				</div>
	
			</div>
		</div>
	
		<div id="hv-drawer-tab-timeline" class="drawer-tab drawer-tab-bottom">Image Timeline</div>
		<div id="hv-drawer-timeline" class="helioviewer-drawer-bottom">
			<div class="drawer-contents" style="height:330px;">
				<div id="hv-drawer-timeline-logarithmic-holder" style="display:block;position:absolute;top:10px;left:10px;z-index:5;"><input type="checkbox" id="hv-drawer-timeline-logarithmic"> Logarithmic View</div>
				<div class="drawer-items">
					<div id="data-coverage-timeline" style="width:100%;height:300px;"></div>
					<button id="btn-prev">&larr; 7 days</button>
					<div id="btn-center" class="viewport-action fa fa-crosshairs qtip-topleft" style="margin-top:-10px;" title="Center Timeline at Observation Date"></div>
					<div id="btn-zoom-out" class="viewport-action fa fa-search-minus qtip-topleft" style="margin-top:-10px;" title="Zoom Out Timeline"></div>
					<div id="btn-zoom-in" class="viewport-action fa fa-search-plus qtip-topleft" style="margin-top:-10px;" title="Zoom In Timeline"></div>
					<button id="btn-next">7 days &rarr;</button>
				</div>
			</div>
		</div>
	
		<div id="hv-drawer-tab-timeline-events" class="drawer-tab drawer-tab-bottom">Events Timeline</div>
		<div id="hv-drawer-timeline-events" class="helioviewer-drawer-bottom">
			<div class="drawer-contents" style="height:330px;">
				<div id="hv-drawer-timeline-events-logarithmic-holder" style="display:none;position:absolute;top:10px;left:10px;z-index:5;"><input type="checkbox" id="hv-drawer-timeline-events-logarithmic"> Logarithmic View</div>
				<div class="drawer-items">
					<div id="data-coverage-timeline-events" style="width:100%;height:300px;"></div>
					<button id="timeline-events-btn-prev">&larr; 7 days</button>
					<div id="timeline-events-btn-center" class="viewport-action fa fa-crosshairs qtip-topleft" style="margin-top:-10px;" title="Center Timeline at Observation Date"></div>
					<div id="timeline-events-btn-zoom-out" class="viewport-action fa fa-search-minus qtip-topleft" style="margin-top:-10px;" title="Zoom Out Timeline"></div>
					<div id="timeline-events-btn-zoom-in" class="viewport-action fa fa-search-plus qtip-topleft" style="margin-top:-10px;" title="Zoom In Timeline"></div>
					<button id="timeline-events-btn-next">7 days &rarr;</button>
				</div>
			</div>
		</div>

		<!-- Glossary dialog -->
		<div id='glossary-dialog'></div>
	
		<!-- About dialog -->
		<div id='about-dialog'></div>
	
		<!-- Layer choice dialog -->
		<div id='layer-choice-dialog'></div>
	
		<!-- Settings dialog -->
		<div id='settings-dialog'>
			<form id='helioviewer-settings'>
				<!-- Initial observation date -->
				<fieldset id='helioviewer-settings-date'>
				<legend>When starting Helioviewer:</legend>
					<div style='padding: 10px;'>
						<input id="settings-date-latest" type="radio" name="date" value="latest" /><label for="settings-date-latest">Display most recent images available</label><br />
						<input id="settings-date-previous" type="radio" name="date" value="last-used" /><label for="settings-date-previous">Display images from previous visit</label><br />
					</div>
				</fieldset>
	
				<br />
	
				<!-- Other -->
				<fieldset id='helioviewer-settings-other'>
				<legend>While using Helioviewer:</legend>
				<div style='padding:10px;'>
					<input type="checkbox" name="latest-image-option" id="settings-latest-image" value="true" />
					<label for="settings-latest-image">Refresh with the latest data every 5 minutes</label><br />
				</div>
				</fieldset>
			</form>
		</div>
	
		<!-- Usage Dialog -->
		<div id='usage-dialog'></div>
	
		<!-- URL Dialog -->
		<div id='url-dialog' style="display:none;">
			<div id="helioviewer-url-box">
				<span id="helioviewer-url-box-msg"></span>
				<form style="margin-top: 5px;">
					<input type="text" class="helioviewer-url-input-box" style="width:98%;" value="http://helioviewer.org" />
					<label for="helioviewer-url-shorten">Shorten with bit.ly? </label>
					<input type="checkbox" class="helioviewer-url-shorten" />
					<input type="hidden" class="helioviewer-short-url" value="" />
					<input type="hidden" class="helioviewer-long-url" value="" />
				</form>
			</div>
		</div>
	
		<!-- Video Upload Dialog -->
		<div id='upload-dialog' style="display: none">
			<!-- Loading indicator -->
			<div id='youtube-auth-loading-indicator' style='display: none;'>
				<div id='youtube-auth-spinner'></div>
				<span style='font-size: 28px;'>Processing</span>
			</div>
	
			<!-- Upload Form -->
			<div id='upload-form'>
				<img id='youtube-logo-large' src="resources/images/youtube_79x32.png" alt='YouTube logo' />
				<h1>Upload Video</h1>
				<br />
				<form id="youtube-video-info" action="/index.php" method="post">
					<!-- Title -->
					<label for="youtube-title">Title:</label>
					<input id="youtube-title" type="text" name="title" maxlength="100" />
					<br />
	
					<!-- Description -->
					<label for="youtube-desc">Description:</label>
					<textarea id="youtube-desc" type="text" rows="5" cols="45" name="description" maxlength="5000"></textarea>
					<br />
	
					<!-- Tags -->
					<label for="youtube-tags">Tags:</label>
					<input id="youtube-tags" type="text" name="tags" maxlength="500" value="" />
					<br /><br />
	
					<!-- Sharing -->
					<div style='float: right; margin-right: 30px;'>
					<label style='width: 100%; margin: 0px;'>
						<input type="checkbox" name="share" value="true" checked="checked" style='width: 15px; float: right; margin: 2px 2px 0 4px;'/>Share my video with other Helioviewer.org users:
					</label>
					<br />
					<input id='youtube-submit-btn' type="submit" value="Submit" />
					</div>
	
					<!-- Hidden fields -->
					<input id="youtube-movie-id" type="hidden" name="id" value="" />
				</form>
				<div id='upload-error-console-container'><div id='upload-error-console'>...</div></div>
			</div>
		</div>
	</div>
	
	
	<!-- Viewport -->
	<div id="helioviewer-viewport-container-outer" class="user-select-none">
		<div id="helioviewer-viewport-container-inner">
			<div id="helioviewer-viewport">
	
				<!-- Movement sandbox -->
				<div id="sandbox" style="position: absolute;">
					<div id="moving-container"></div>
				</div>
	
				<!-- Message console -->
				<div id="message-console"></div>
	
				<!-- Image area select boundary container -->
				<div id="image-area-select-container"></div>
			</div>
		</div>
	</div>
	
	<!-- Library JavaScript -->
	<script src="resources/lib/jquery/jquery-1.12.1.min.js" type="text/javascript"></script>
	<script src="resources/lib/jquery/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="resources/lib/jquery-ui/jquery-ui-1.9.2.min.js" type="text/javascript"></script>
	<script src="resources/lib/jquery.class/jquery.class.min.js" type="text/javascript"></script>
	<script src="resources/lib/jquery.mousewheel/jquery.mousewheel.3.1.13.min.js" type="text/javascript"></script>
	<script src="resources/lib/date.js/date-en-US.js" type="text/javascript"></script>
	<script src="resources/lib/jquery.qTip2/jquery.qtip.min.js" type="text/javascript"></script>
	<script src="resources/lib/jquery.qTip2/imagesloaded.pkg.min.js" type="text/javascript"></script>
	<script src="resources/lib/jquery-number-master/jquery.number.min.js" type="text/javascript"></script>
	<script src="resources/lib/jquery.json-2.3/jquery.json-2.3.min.js" type="text/javascript" ></script>
	<script src="resources/lib/jquery.cookie/jquery.cookie.min.js" type="text/javascript" ></script>
	<script src="resources/lib/Cookiejar/jquery.cookiejar.pack.js" type="text/javascript"></script>
	<script src="resources/lib/Highstock-4.2.1/js/highstock.js" type="text/javascript"></script>
	<script src="resources/lib/Highstock-4.2.1/js/highcharts-more.js" type="text/javascript"></script>
	<script src="resources/lib/custom_events-master/customEvents.js" type="text/javascript"></script>
	<script src="resources/lib/jquery.jgrowl/jquery.jgrowl_minimized.js" type="text/javascript"></script>
	<script src="resources/lib/jquery.imgareaselect-0.9.8/scripts/jquery.imgareaselect.pack.js" type="text/javascript"></script>
	<script src="resources/lib/jquery.jfeed/build/jquery.jfeed.js" type="text/javascript"></script>
	<script src="resources/lib/jquery.xml2json/jquery.xml2json.pack.js" type="text/javascript" language="javascript"></script>
	<script src="resources/lib/jquery.jsTree-1.0rc/jquery.jstree.min.js"></script>
	<script src="resources/lib/DatetimePicker/build/jquery.datetimepicker.full.js" type="text/javascript" language="javascript"></script>
	<script src="resources/lib/period_picker.2.7.8.pro/build/jquery.periodpicker.full.min.js" type="text/javascript" language="javascript"></script>
	<script src="resources/lib/period_picker.2.7.8.pro/jquery.timepicker.js" type="text/javascript" language="javascript"></script>
	<script src="resources/lib/boneVojage/jquery.bonevojage.js" type="text/javascript" language="javascript"></script>

	<!-- Helioviewer JavaScript -->
	<?php
	if ($debug){	
	?>
		<script src="resources/js/Utility/Config.js" type="text/javascript"></script>
		<script src="resources/js/Utility/HelperFunctions.js" type="text/javascript"></script>
		<script src="resources/js/Tiling/Layer/Layer.js" type="text/javascript"></script>
		<script src="resources/js/Tiling/Layer/TileLoader.js" type="text/javascript"></script>
		<script src="resources/js/Tiling/Layer/TileLayer.js" type="text/javascript"></script>
		<script src="resources/js/Tiling/Layer/HelioviewerTileLayer.js" type="text/javascript"></script>
		<script src="resources/js/Utility/KeyboardManager.js" type="text/javascript"></script>
		<script src="resources/js/Tiling/Manager/LayerManager.js" type="text/javascript"></script>
		<script src="resources/js/Tiling/Manager/TileLayerManager.js" type="text/javascript"></script>
		<script src="resources/js/Tiling/Manager/HelioviewerTileLayerManager.js" type="text/javascript"></script>
		<script src="resources/js/Image/JP2Image.js" type="text/javascript"></script>
		<script src="resources/js/Viewport/Helper/MouseCoordinates.js" type="text/javascript"></script>
		<script src="resources/js/Viewport/Helper/HelioviewerMouseCoordinates.js" type="text/javascript"></script>
		<script src="resources/js/Viewport/Helper/SandboxHelper.js" type="text/javascript"></script>
		<script src="resources/js/Viewport/Helper/ViewportMovementHelper.js" type="text/javascript"></script>
		<script src="resources/js/Viewport/HelioviewerViewport.js" type="text/javascript"></script>
		<script src="resources/js/HelioviewerClient.js" type="text/javascript"></script>
		<script src="resources/js/UI/ZoomControls.js" type="text/javascript"></script>
		<script src="resources/js/UI/ImageScale.js" type="text/javascript"></script>
		<script src="resources/js/UI/Timeline.js" type="text/javascript"></script>
		<script src="resources/js/UI/TimelineEvents.js" type="text/javascript"></script>
		<script src="resources/js/Utility/InputValidator.js" type="text/javascript"></script>
		<script src="resources/js/Utility/SettingsLoader.js" type="text/javascript"></script>
		<script src="resources/js/Utility/UserSettings.js" type="text/javascript"></script>
		<script src="resources/js/Utility/Tutorial.js" type="text/javascript"></script>
		<script src="resources/js/Tiling/Manager/LayerManager.js" type="text/javascript"></script>
		<script src="resources/js/Events/EventManager.js" type="text/javascript"></script>
		<script src="resources/js/Events/EventType.js" type="text/javascript"></script>
		<script src="resources/js/Events/EventTree.js" type="text/javascript"></script>
		<script src="resources/js/Events/EventFeatureRecognitionMethod.js" type="text/javascript"></script>
		<script src="resources/js/Events/EventLayerManager.js" type="text/javascript"></script>
		<script src="resources/js/Events/EventMarker.js" type="text/javascript"></script>
		<script src="resources/js/Events/EventLayerManager.js" type="text/javascript"></script>
		<script src="resources/js/Events/HelioviewerEventLayer.js" type="text/javascript"></script>
		<script src="resources/js/Events/HelioviewerEventLayerManager.js" type="text/javascript"></script>
		<script src="resources/js/UI/TreeSelect.js" type="text/javascript"></script>
		<script src="resources/js/UI/ImageSelectTool.js" type="text/javascript"></script>
		<script src="resources/js/Media/MediaManagerUI.js" type="text/javascript"></script>
		<script src="resources/js/Media/MediaManager.js" type="text/javascript"></script>
		<script src="resources/js/Media/MovieManager.js" type="text/javascript"></script>
		<script src="resources/js/Media/MovieManagerUI.js" type="text/javascript"></script>
		<script src="resources/js/Media/ScreenshotManager.js" type="text/javascript"></script>
		<script src="resources/js/Media/ScreenshotManagerUI.js" type="text/javascript"></script>
		<script src="resources/js/UI/TileLayerAccordion.js" type="text/javascript"></script>
		<script src="resources/js/UI/EventLayerAccordion.js" type="text/javascript"></script>
		<script src="resources/js/UI/MessageConsole.js" type="text/javascript"></script>
		<script src="resources/js/UI/TimeControls.js" type="text/javascript"></script>
		<script src="resources/js/Utility/FullscreenControl.js" type="text/javascript"></script>
		<script src="resources/js/HelioviewerWebClient.js" type="text/javascript"></script>
		<script src="resources/js/UI/UserVideoGallery.js" type="text/javascript"></script>
		<script src="resources/js/UI/Glossary.js" type="text/javascript"></script>
		<script src="resources/js/UI/jquery.ui.dynaccordion.js" type="text/javascript"></script>
	<?php
	} else {	
	?>
		<script src="resources/compressed/helioviewer.min.js?v=<?=filemtime('resources/compressed/helioviewer.min.js')?>" type="text/javascript"></script>
	<?php
	}	
	?>
	
	<!-- Launch Helioviewer -->
	<script type="text/javascript">
		var serverSettings, settingsJSON, urlSettings, debug, scrollLock = false;
		
		function getUrlParameters() {
			var sPageURL = decodeURIComponent(decodeURIComponent(window.location.search.substring(1))),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i,
				data = {};

			data['eventLabels'] = true;
			data['imageLayers'] = '';
			data['eventLayers'] = '';
				
			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');
				
				if (sParameterName[0] === 'imageScale') {
					data['imageScale'] = parseFloat(sParameterName[1]);
				}else if (sParameterName[0] === 'centerX') {
					data['centerX'] = parseFloat(sParameterName[1]);
				}else if (sParameterName[0] === 'centerY') {
					data['centerY'] = parseFloat(sParameterName[1]);
				}else if (sParameterName[0] === 'imageLayers') {
					// Process imageLayers separately if set
					if (sParameterName[1] != '') {
						if (sParameterName[1][0] == '[') {
							var str = sParameterName[1];
							var imageLayersString = str.slice(1, -1);
						} else {
							var imageLayersString = sParameterName[1];
						}
						data['imageLayers'] = imageLayersString.split("],[");
					}
					else {
						data['imageLayers'] = '';
					}
				}else if (sParameterName[0] === 'eventLayers') {
					//Process eventLayers separately if set
					if (sParameterName[1] != '') {
						if (sParameterName[1][0] == '[') {
							var str = sParameterName[1];
							var imageLayersString = str.slice(1, -1);
						} else {
							var imageLayersString = sParameterName[1];
						}
						data['eventLayers'] = imageLayersString.split("],[");
					}
					else {
						data['eventLayers'] = '';
					}
				}else if (sParameterName[0] === 'eventLabels') {
					if ( typeof sParameterName[1] != 'undefined' && (sParameterName[1] == false  || sParameterName[1] == 'false' ) ) {
						data['eventLabels'] = false;
					}
				}else{
					data[sParameterName[0]] = sParameterName[1];
				}
			}
			return data;
		};
		
		$( document ).ready(function(){
			settingsJSON = {};
			serverSettings = new Config(settingsJSON).toArray();
			zoomLevels = [0.60511022,1.21022044,2.42044088,4.84088176,9.68176352,19.36352704,38.72705408,77.45410816,154.90821632];

			urlSettings = getUrlParameters();
	
			// Initialize Helioviewer.org
			helioviewer = new HelioviewerWebClient(urlSettings, serverSettings, zoomLevels);

			// Play movie if id is specified
			if (urlSettings.movieId) {
				helioviewer.loadMovie(urlSettings.movieId);
			}
		});
	</script>
	
</body>
</html>