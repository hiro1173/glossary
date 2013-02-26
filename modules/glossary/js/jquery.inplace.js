/*
+-----------------------------------------------------------------------+
| Copyright (c) 2007 David Hauenstein			                        |
| All rights reserved.                                                  |
|                                                                       |
| Redistribution and use in source and binary forms, with or without    |
| modification, are permitted provided that the following conditions    |
| are met:                                                              |
|                                                                       |
| o Redistributions of source code must retain the above copyright      |
|   notice, this list of conditions and the following disclaimer.       |
| o Redistributions in binary form must reproduce the above copyright   |
|   notice, this list of conditions and the following disclaimer in the |
|   documentation and/or other materials provided with the distribution.|
|                                                                       |
| THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
| "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
| LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
| A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
| OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
| SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
| LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
| DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
| THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
| (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
| OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
|                                                                       |
+-----------------------------------------------------------------------+
*/

/* $Id: jquery.inplace.js,v 0.9.9.2 2007/12/04 09:39:00 hauenstein Exp $ */

/**
  * jQuery inplace editor plugin.  
  *
  * Created by: David Hauenstein
  * http://www.davehauenstein.com/blog/
  *
  *
  * Nate Wiger (http://www.dangerrabbit.com) added callbacks, exposed 
  * more settings, added required values and "selected" options,
  * and enabled compatibility with jQuery.noConflict() mode.
  * Thanks to Joe and Vaska for helping me get this working on jQuery 1.1
  * Thanks to Pranav (http://www.startupdunia.com/) for finding a scope bug (0.9.4 release)
  * Thanks to Simon for finding some extraneous code (0.9.5 release)
  *
  *
  * @name  editInPlace
  * @type  jQuery
  * @param Hash    options						additional options 
  * @param String  options[url]					POST URL to send edited content
  * @param String  options[params]				paramters sent via the post request to the server; string; ex: name=dave&last_name=hauenstein
  * @param String  options[field_type]			can be: text, textarea, select; default: text
  * @param String  options[select_options]		this is a string seperated by commas for the dropdown options, if field_type is dropdown
  * @param String  options[textarea_cols]		number of columns textarea will have, if field_type is textarea; default: 25
  * @param String  options[textarea_rows]		number of rows textarea will have, if field_type is textarea; default: 10
  * @param String  options[bg_over]				background color of editable elements on HOVER
  * @param String  options[bg_out]				background color of editable elements on RESTORE from hover
  * @param String  options[saving_text]			text to be used when server is saving information; default: 'Saving...'
  * @param String  options[saving_image]		specify an image location instead of text while server is saving; default: uses saving text
  * @param String  options[value_required]		if set to true, the element will not be saved unless a value is entered
  * @param String  options[element_id]			name of parameter holding element_id; default: element_id
  * @param String  options[update_value]		name of parameter holding update_value; default: update_value
  * @param String  options[original_html]		name of parameter holding original_html; default: original_html
  * @param String  options[save_button]			image button tag to use as "Save" button
  * @param String  options[cancel_button]		image button tag to use as "Cancel" button
  * @param String  options[callback]			call function instead of submitting to url
  *             
  */

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('8.28.22=9(W){5 2={L:"",q:"",C:"l",1b:"",18:"25",16:"10",1l:"#2g",w:"1T",1a:"19...",x:"",J:"(24 1B G 2a l)",1d:"2b 1p d",1g:11,T:"T",Z:"Z",b:"b",1m:\'<R F="1q" k="12" d="2c"/>\',1k:\'<R F="1q" k="1r" d="2e"/>\',P:11,E:11,K:9(r){U("1f G V d: "+r.2f||\'29 1j\')}};6(W){8.1s(2,W)}6(2.x!=""){5 13=1p 1u();13.15=2.x}14.1n.t=9(){m 7.o(/^\\s+/,\'\').o(/\\s+$/,\'\')};14.1n.z=9(){m 7.o(/&/g,"&1v;").o(/</g,"&1w;").o(/>/g,"&1x;").o(/"/g,"&1z;")};m 7.1A(9(){6(8(7).3()=="")8(7).3(2.J);5 e=c;5 4=8(7);5 f=0;8(7).1R(9(){8(7).v("u",2.1l)}).1P(9(){8(7).v("u",2.w)}).X(9(){f++;6(!e){e=1O;5 b=8(7).3();5 1o=2.1m+\' \'+2.1k;6(b==2.J)8(7).3(\'\');6(2.C=="Y"){5 p=\'<Y S="O" k="H" 1F="\'+2.16+\'" 1G="\'+2.18+\'">\'+8(7).l().t().z()+\'</Y>\'}j 6(2.C=="l"){5 p=\'<R F="l" S="O" k="H" d="\'+8(7).l().t().z()+\'" />\'}j 6(2.C=="I"){5 N=2.1b.1i(\',\');5 p=\'<I S="O" k="H"><D d="">\'+2.1d+\'</D>\';1I(5 i=0;i<N.1J;i++){5 B=N[i].1i(\':\');5 M=B[1]||B[0];5 A=M==b?\'A="A" \':\'\';p+=\'<D \'+A+\'d="\'+M.t().z()+\'">\'+B[0].t().z()+\'</D>\'}p+=\'</I>\'}8(7).3(\'<y k="1M" 1N="1V: 1W; 1Y: 0; 1Z: 0;">\'+p+\' \'+1o+\'</y>\')}6(f==1){4.h("y").h(".H").21().I();$(20).26(9(1c){6(1c.2d==27){e=c;f=0;4.v("u",2.w);4.3(b);m c}});4.h("y").h(".1r").X(9(){e=c;f=0;4.v("u",2.w);4.3(b);m c});4.h("y").h(".12").X(9(){4.v("u",2.w);5 n=8(7).1U().h(0).1C();6(2.x!=""){5 Q=\'<1D 15="\'+2.x+\'" 1H="19..." />\'}j{5 Q=2.1a}4.3(Q);6(2.q!=""){2.q="&"+2.q}6(2.P){3=2.P(4.1e("1h"),n,b,2.q);e=c;f=0;6(3){4.3(3||n)}j{U("1f G V d: "+n);4.3(b)}}j 6(2.1g&&n==""){e=c;f=0;4.3(b);U("1j: 1K 1L 1Q a d G V 7 23")}j{8.1t({L:2.L,F:"1y",1E:2.Z+\'=\'+n+\'&\'+2.T+\'=\'+4.1e("1h")+2.q+\'&\'+2.b+\'=\'+b,1S:"3",1X:9(r){e=c;f=0},E:9(3){5 17=3||2.J;4.3(17);6(2.E)2.E(3,4)},K:9(r){4.3(b);6(2.K)2.K(r,4)}})}m c})}})})};',62,141,'||settings|html|original_element|var|if|this|jQuery|function||original_html|false|value|editing|click_count||children||else|class|text|return|new_html|replace|use_field_type|params|request||trim|background|css|bg_out|saving_image|form|escape_html|selected|optionsValuesArray|field_type|option|success|type|to|inplace_field|select|default_text|error|url|use_value|optionsArray|inplace_value|callback|saving_message|input|name|element_id|alert|save|options|click|textarea|update_value||null|inplace_save|loading_image|String|src|textarea_rows|new_text|textarea_cols|Saving|saving_text|select_options|event|select_text|attr|Failed|value_required|id|split|Error|cancel_button|bg_over|save_button|prototype|buttons_code|new|submit|inplace_cancel|extend|ajax|Image|amp|lt|gt|POST|quot|each|here|val|img|data|rows|cols|alt|for|length|You|must|inplace_form|style|true|mouseout|enter|mouseover|dataType|transparent|parent|display|inline|complete|margin|padding|document|focus|editInPlace|field|Click||keyup||fn|Unspecified|add|Choose|Save|keyCode|Cancel|responseText|ffc'.split('|'),0,{}))
