<?
require_once("docutil.php");
page_head("Exporting statistics data");
echo "

<p>
BOINC projects may export data describing teams, users and hosts.
This data is exported in XML files that can be downloaded
by HTTP from a designated server.

<p>
The data is presented in several different 'views':
teams ordered by credit, teams ordered by ID, etc.
To increase the efficiency of data access,
views are broken into a number of files,
each containing a fixed number of records.
<p>
The entries in a given file are in either 'summary' or 'detail' form.
For example, the summary of a team gives its ID, name, and credit,
while the detailed from also contains a list of its members.
<p>
These files can be zipped or gzipped by passing the '-zip' or '-gzip'
command to the db_dump program.
<p>
The files are as follows:

<p>
<b>tables.xml</b>
<p>
For each table (team, user, and host) this gives
<ul>
<li> the total number of records
<li> the number of records per file for summary files
<li> the number of records per file for detail files
</ul>
It also includes the UNIX time when the files were last generated.<br>
For example:
<pre>
&lt;tables>
    &lt;update_time>1046220857&lt;/nupdate_time>
    &lt;nusers_total>127&lt;/nusers_total>
    &lt;nusers_per_file_summary>1000&lt;/nusers_per_file_summary>
    &lt;nusers_per_file_detail>100&lt;/nusers_per_file_detail>
    &lt;nteams_total>14&lt;/nteams_total>
    &lt;nteams_per_file_summary>1000&lt;/nteams_per_file_summary>
    &lt;nteams_per_file_detail>100&lt;/nteams_per_file_detail>
    &lt;nhosts_total>681&lt;/nhosts_total>
    &lt;nhosts_per_file_summary>1000&lt;/nhosts_per_file_summary>
    &lt;nhosts_per_file_detail>100&lt;/nhosts_per_file_detail>
&lt;/tables>
</pre>
<b>team_total_credit_N.xml</b>
<br>
Team summaries, ordered by decreasing <a href=credit.php>total credit</a><.
N is 0, 1, ...
<p>
<b>team_expavg_credit_N.xml</b>
<br>
Team summaries, ordered by decreasing <a href=credit.php>recent-average credit</a>.
<p>
<b>team_id_N.xml</b>
<br>
Team details, ordered by increasing ID.
<p>
<b>user_total_credit_N.xml</b>
<br>
User summaries, ordered by decreasing total credit.
<p>
<b>user_expavg_credit_N.xml</b>
<br>
User summaries, ordered by decreasing recent-average credit.
<p>
<b>user_id_N.xml</b>
<br>
User details, ordered by increasing ID.
<p>
<b>host_total_credit_N.xml</b>
<br>
Host summaries, ordered by decreasing total credit.
<p>
<b>host_expavg_credit_N.xml</b>
<br>
Host summaries, ordered by decreasing recent-average credit.
<p>
<b>host_id_N.xml</b>
<br>
Host details, ordered by increasing ID.
<p>
The format of the various XML elements is as follows:

<p>
<b>Team summary</b>
<pre>
&lt;team>
 &lt;id>5&lt;/id>
 &lt;name>Broadband Reports Team Starfire&lt;/name>
 &lt;total_credit>153402.872429&lt;/total_credit>
 &lt;expavg_credit>503030.483254&lt;/expavg_credit>
 &lt;nusers>14&lt;/nusers>
&lt;/team>
</pre>
<p>
<b>Team detail</b>
<pre>
&lt;team>
 &lt;id>5&lt;/id>
 &lt;name>Broadband Reports Team Starfire&lt;/name>
 &lt;total_credit>153402.872429&lt;/total_credit>
 &lt;expavg_credit>503030.483254&lt;/expavg_credit>
 &lt;nusers>14&lt;/nusers>
 &lt;create_time>0&lt;/create_time>
&lt;name_html>%3Ca%20href%3D%27http%3A%2F%2Fbroadbandreports%2Ecom%2Fforum%2Fseti%2
7%3E%3Cimg%20src%3D%27http%3A%2F%2Fi%2Edslr%2Enet%2Fpics%2Ffaqs%2Fimage2067%2Ejp
g%27%3E&lt;/name_html>
 &lt;country>None&lt;/country>
 &lt;user>
  &lt;id>12&lt;/id>
  &lt;name>John Keck&lt;/name>
  &lt;total_credit>42698.813543&lt;/total_credit>
  &lt;expavg_credit>117348.653646&lt;/expavg_credit>
  &lt;teamid>5&lt;/teamid>
 &lt;/user>
 &lt;user>
  &lt;id>14&lt;/id>
  &lt;name>Liontaur&lt;/name>
  &lt;total_credit>46389.595430&lt;/total_credit>
  &lt;expavg_credit>122936.372641&lt;/expavg_credit>
  &lt;teamid>5&lt;/teamid>
 &lt;/user>
&lt;/team>
</pre>
<p>
<b>User summary</b>
<pre>
&lt;user>
 &lt;id>12&lt;/id>
 &lt;name>John Keck&lt;/name>
 &lt;total_credit>42698.813543&lt;/total_credit>
 &lt;expavg_credit>117348.653646&lt;/expavg_credit>
 &lt;teamid>5&lt;/teamid>
&lt;/user>
</pre>
<p>
<b>User detail</b>
<pre>
&lt;user>
 &lt;id>3&lt;/id>
 &lt;name>Eric Heien&lt;/name>
 &lt;total_credit>4897.904591&lt;/total_credit>
 &lt;expavg_credit>9820.631754&lt;/expavg_credit>
 &lt;country>United States&lt;/country>
&lt;create_time>1046220857&lt;/ncreate_time>
 &lt;teamid>14&lt;/teamid>
 &lt;host>
    &lt;id>27&lt;/id>
    &lt;total_credit>0.000000&lt;/total_credit>
    &lt;expavg_credit>0.000000&lt;/expavg_credit>
    &lt;p_vendor>&lt;/p_vendor>
    &lt;p_model>&lt;/p_model>
    &lt;os_name>Darwin&lt;/os_name>
    &lt;os_version>6.2&lt;/os_version>
 &lt;/host>
 &lt;host>
    &lt;id>266&lt;/id>
    &lt;total_credit>0.000000&lt;/total_credit>
    &lt;expavg_credit>0.000000&lt;/expavg_credit>
    &lt;p_vendor>GenuineIntel&lt;/p_vendor>
    &lt;p_model>Intel(R)&lt;/p_model>
    &lt;os_name>Linux&lt;/os_name>
    &lt;os_version>2.4.18-18.7.x&lt;/os_version>
 &lt;/host>
&lt;/user>
</pre>
<p>
<b>Host summary</b>
<pre>
&lt;host>
  &lt;id>266&lt;/id>
  &lt;total_credit>0.000000&lt;/total_credit>
  &lt;expavg_credit>0.000000&lt;/expavg_credit>
  &lt;p_vendor>GenuineIntel&lt;/p_vendor>
  &lt;p_model>Intel(R)&lt;/p_model>
  &lt;os_name>Linux&lt;/os_name>
  &lt;os_version>2.4.18-18.7.x&lt;/os_version>
&lt;/host>
</pre>
<p>
<b>Host detail</b>
<pre>
&lt;host>
  &lt;id>102&lt;/id>
  &lt;userid>3&lt;/userid>
  &lt;total_credit>0.000000&lt;/total_credit>
  &lt;expavg_credit>0.000000&lt;/expavg_credit>
  &lt;p_vendor>GenuineIntel&lt;/p_vendor>
  &lt;p_model>Pentium&lt;/p_model>
  &lt;os_name>Windows XP&lt;/os_name>
  &lt;os_version>5.1&lt;/os_version>
  &lt;create_time>1040170006&lt;/create_time>
  &lt;timezone>28800&lt;/timezone>
  &lt;ncpus>2&lt;/ncpus>
  &lt;p_fpops>45724737.082762&lt;/p_fpops>
  &lt;p_iops>43233895.373973&lt;/p_iops>
  &lt;p_membw>4032258.064516&lt;/p_membw>
  &lt;m_nbytes>670478336.000000&lt;/m_nbytes>
  &lt;m_cache>1000000.000000&lt;/m_cache>
  &lt;m_swap>1638260736.000000&lt;/m_swap>
  &lt;d_total>9088008192.000000&lt;/d_total>
  &lt;d_free>3788505088.000000&lt;/d_free>
  &lt;n_bwup>24109.794088&lt;/n_bwup>
  &lt;n_bwdown>57037.049858&lt;/n_bwdown>
&lt;/host>
</pre>
";
page_tail();
?>
