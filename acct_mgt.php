<?php
require_once("docutil.php");

page_head("Account management systems");

echo "
<p>
To create an account with BOINC projects, a participant must:
<ul>
<li> Locate BOINC project web sites, e.g. using Google.
<li> Read the web sites, and decide which to join;
<li> Download and install the BOINC client software.
</ul>
and then for each selected project:
<ul>
<li> Go through the Attach to Project wizard.
</ul>

<p>
If the participant chooses N projects,
there are N web sites to visit and N Wizards to complete.
This is tedious if there are lots of projects.

<p>
This document describes BOINC's support for <b>account management systems</b>,
which streamline the process of finding and joining BOINC projects.
A typical account management system is implemented as a web site.
The participant experience is:
<ul>
<li> Visit the account manager site,
set up a 'meta-account' (name, email, password),
browse a list of projects, and click checkboxes to select projects.
<li> Download and install the BOINC client software from the account manager.
<li> Enter the meta-account name and password in a BOINC client dialog.
</ul>
This requires many fewer interactions than the manual approach.

<h2>Implementation</h2>
<p>
An account management system works as follows:
<br>
<img src=acct_mgt2.png>
<br>

<ol>
<li> The participant sets up his meta-account and selects projects.
<li> The account manager issues a <b>create account</b> RPC
to each selected project.
<li> 
the participant downloads and installs the BOINC client software
from the account manager.
The install package includes a file
(specific to the account manager)
containing the URL of the account manager.
<li> The BOINC client runs, and asks the participant to enter
the name and password of his meta-account.
<li> The BOINC client does a <b>query accounts</b> RPC
to the account manager, obtaining a list of accounts.
It then attaches to these accounts and proceeds.
</ol>

The <b>create account</b> RPCs
are described <a href=web_rpc.php>here</a>.

<h2>Core client functionality</h2>
<p>
The BOINC core client uses the following files to
keep track of account manager information.
<dl>
<dt>
<b>acct_mgr_url.xml</b>
<dd>
This file identifies the account manager.
It is typically bundled with the BOINC client in
an installer package.
Its format is:
".html_text("
<acct_mgr>
    <name>Name of BOINC account management system</name>
    <url>http://acctmgr.com/</url>
</acct_mgr>
")."

<p>
Note: the URL is that of the account manager's web site.

<dt>
<b>acct_mgr_login.xml</b>
<dd>
This file contains meta-account information.
Its format is:
".html_text("
<acct_mgr_login>
   <login>name</login>
   <password_hash>xxx</password_hash>
</acct_mgr_login>
")."
</dl>
<p>
The password is stored as MD5(password_lowercase(login)).
<p>
If the core client finds acct_mgr_url.xml but not acct_mgr_login.xml,
it prompts for a name and password,
stores them in acct_mgr_login.xml,
and makes an account manager RPC.
The core client offers menu items for making an account manager RPC,
and for changing the name/password.

<h2>Account manager RPC</h2>

The core client contacts the account manager
using an HTTP POST request.
";

list_start();
list_item("URL", "<b>BASE_URL/rpc.php</b>, where BASE_URL is the URL
        of the account manager web site.");
list_item("input", html_text("
<acct_mgr_request>
    <name>John</name>
    <password_hash>xxx</password_hash>
    <host_cpid>b11ddc5f36c9a86ff093c96e6930646a</host_cpid>
    <client_version>5.3.2</client_version>
    <run_mode>auto</run_mode>
    <project>
       <url>http://setiathome.berkeley.edu/</url>
       <project_name>SETI@home</project_name>
       <suspended_via_gui>0</suspended_via_gui>
    </project>
    ...
</acct_mgr_request>
")
);
list_item("output",
    html_text("<acct_mgr_reply>
    <name>Account Manager Name</name>
    <signing_key>
1024
ae843acebd4c7250b0fa575d14971b17a56a386a6bb1733d98f4b00460c26159
c8b3217e6cdff938ec0454330c70553fbe3d1f0d0184d8c628db2e093121ee98
8ddbda6e8991879317afccab41f84e9de4903a656f4d3f3e4e7dbc0af9362a05
6ece5ff401a380f3a1d1254d477f7bc84fdcebcca6cb035e776452d3d6d21471
0000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000000000
0000000000000000000000000000000000000000000000000000000000010001
.
    </signing_key>
    [ <error>MSG</error> ]
    [ <repeat_sec>xxx</repeat_sec> ]
    [ 
      <account>
         <url>URL</url>
         <url_signature>
397d250e02ec02be8141b8d196a118d909d5ec73e592ed50f9d0ad1ce5bf87de
e37f48079db76128b20f913a04e911489330a7cab8c346177f1682d236bc7201
42b32665d0d83474bf12aebd97b2bb9a4c4461fa3f0b49bbd40ecfa16715ced7
f72103eb0995be77cac54f253c0ba639a814d3293646ae11894e9d1367a98790
.
         </url_signature>
         <authenticator>KEY</authenticator>
         [ <detach/> ]
      </account>
        ...
    ]
</acct_mgr_reply>")
);
list_item("action",
    "Returns a list of the accounts associated with this meta-account.
    The arguments are:
    <dl>
    <dt>password_hash
    <dd>
    the account password, hashed as MD5(password_lowercase(name)).
    <dt>host_cpid
    <dd>
    Identifies the host.
    To make it comparable with the host CPID in stats files,
    the value MD5(host_cpid+email_addr) is passed.
    </dl>
    The return values are:
    <dl>
    <dt>repeat_sec
    <dd>
    A time interval after which another RPC should be done.
    <dt> signing_key
    The public key used to sign URLs, in an encoded notation.
    Use the BOINC <a href=key_setup.php>crypt_prog</a> program to generate this.
    <dd>
    </dl>
    For each account, the following items are returned:
    <dl>
    <dt>url
    <dd>The project URL
    <dt>url_signature
    <dd>A signature for the URL.
    Use the BOINC <a href=key_setup.php>crypt_prog</a> program to generate this.
    <dt>authenticator
    <dd>The account's authenticator.
    <dt>detach
    <dd>If present, the client should detach this project.
    </dl>
    NOTE: the XML must be as above, with the &lt;url>
    and &lt;authenticator> elements on a single line,
    and the &lt;account> and &lt;/account> tags
    on separate lines."
);
list_end();

page_tail();
?>
