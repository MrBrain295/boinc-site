<?php
require_once("docutil.php");
page_head("Building BOINC on Unix");

echo "
The BOINC software consists of several components:
<p>
<center>
<img src=components.png>
</center>
<p>
<ul>
<li> <b>Miscellaneous</b>: the API and various shared code.
<li> <b>Client</b>: the core client and Manager.
<li> <b>Server</b>: the scheduler, file upload handler, daemons, and tools.
</ul>
On UNIX systems, the BOINC software can be built by typing
<pre>
./_autosetup
./configure [see options below]
make
</pre>
in the top directory.
<ul>
<li> If you're creating a project, you need to build the server
and miscellaneous software
(you <b>don't</b> need to build the client software;
participants can get that from the BOINC web site).
Use
<pre>
./configure --disable_client
</pre>
<li> If you're porting the BOINC client software to a new platform,
you need the client and miscellaneous components.
Use
<pre>
./configure --disable_server
</pre>
<li> If you're developing or porting a BOINC application,
you need only the miscellaneous component.
Use
<pre>
./configure --disable_server --disable_client
</pre>
</ul>


<h3>Configuration</h3>

<p>
Usage:
<pre>
./configure [OPTION]... [VAR=VALUE]...
</pre>

You can use environment
variables to override the choices made by `configure' or to help
it to find libraries and programs with nonstandard names/locations.
To assign environment variables (e.g., CC, CFLAGS...), specify them as
VAR=VALUE.
Example: to compile BOINC with strict compiler warnings, use
<pre>
./configure CXXFLAGS=\"-Wall -W -Wmissing-prototypes -Wstrict-prototypes -Wshadow -Wpointer-arith -Wcast-qual -Wcast-align -Wwrite-strings -fno-common \"
</pre>

<p>
Defaults for the options are specified in brackets.
";
list_start();
list_bar("Configuration");
list_item("-h, --help",
    "display configuration options and exit"
);
list_item("--host=HOST",
    "Use HOST to identify platforms in executable names.
    For Linux/x86 builds, use
    --build=i686-pc-linux-gnu"
);
list_bar("Installation directories");
list_item("--prefix=PREFIX",
    "install architecture-independent files in PREFIX [/usr/local]
    By default, `make install' will install all the files in
    `/usr/local/bin', `/usr/local/lib' etc.  You can specify
    an installation prefix other than `/usr/local' using `--prefix',
    for instance `--prefix=$HOME'.
    For better control, use the options below."
);

list_bar("Optional Features");
list_item("--disable-FEATURE",
    "do not include FEATURE (same as --enable-FEATURE=no)"
);
list_item("--enable-FEATURE[=ARG]",
    "include FEATURE [ARG=yes]"
);
list_item("--enable-debug",
    "enable tracing and debugging flags for all components"
);
list_item("--disable-server",
    "disable building the server component"
);
list_item("--disable-client",
    "disable building the client component
    Default: --enable-server --enable-client: builds
    both server and client.
    <p>
    If configure can't find WxWidgets it will build
    the core client but not the Manager.
    If you want to build only the core client,
    run configure with --with-wxdir=junk.
    "
);
list_item("--enable-maintainer-mode",
    "enable make rules and dependencies not useful
    (and sometimes confusing) to the casual installer"
);
list_item("--enable-shared[=PKGS]",
    "build shared libraries [default=yes]"
);
list_item("--enable-static[=PKGS]",
     "build static libraries [default=yes]"
);
list_item("--disable-static-linkage",
     "disable static linking of certain libraries"
);
list_item("--enable-client-release",
    "Try building a portable 'release-candidate'
    (currently implemented for Linux and Solaris only):
    this links libstd++ statically. You will probably
    need gcc-3.0 for this to produce a portable
    client-binary. It is therefore recommended to use
    CC=gcc-3.0 and CXX=g++-3.0 for this. (Default = no)"
);

list_bar("Optional Packages");
list_item("--with-PACKAGE[=ARG]",
    "use PACKAGE [ARG=yes]"
);
list_item("--without-PACKAGE",
    "do not use PACKAGE (same as --with-PACKAGE=no)"
);
list_item("--with-x",
    "use the X Window System"
);
list_item("--with-apple-opengl-framework",
     "use Apple OpenGL framework (Mac OS X only)"
);
list_item("--with-wxdir=PATH",
    "Use uninstalled version of wxWindows in PATH"
);
list_item("--with-wx-config=CONFIG",
    "wx-config script to use (optional)"
);

list_bar("Environment variables");
list_item("CC",
    "C compiler command"
);
list_item("CFLAGS",
    "C compiler flags"
);
list_item("LDFLAGS",
    "linker flags, e.g. -L&lt;lib dir&gt; if you have libraries in a
    nonstandard directory &lt;lib dir&gt;"
);
list_item("CPPFLAGS",
    "C/C++ preprocessor flags, e.g. -I&lt;include dir&gt; if you have
      headers in a nonstandard directory &lt;include dir&gt;"
);
list_item("CXX",
    "C++ compiler command"
);
list_item("CXXFLAGS",
    "C++ compiler flags.
    "
);
list_item("CPP",
    "C preprocessor"
);
list_item("CXXCPP",
    "C++ preprocessor"
);
list_item("F77",
    "Fortran 77 compiler command"
);
list_item("FFLAGS",
    "Fortran 77 compiler flags"
);
list_item("MYSQL_CONFIG",
     "mysql_config program"
);
list_end();
echo "


<h2>Source layout</h2>

<p>
  The top-level <code>Makefile.am</code> contains the
  <code>SUBDIRS=</code> line which sets up directory recursion, and
  the rules for creating source distributions.
<p>
  Each subdirectory's <code>Makefile.am</code> contains the rules for
  making the binaries and libraries in that directory and any extra
  files to distribute.
<p>
  Usually you will want to run <code>make</code> from the top level
  (the directory containing the file <code>configure</code>), but
  sometimes it is useful to run <code>make</code> and <code>make
    check</code> in certain subdirectories (e.g. <code>client/</code>).

<h2>Adding new directories</h2>
If you create a new directory with another <code>Makefile.am</code>,
you should
<ul>
<li> make sure the directory is referenced by
a <code>SUBDIRS=</code> line from its
parent <code>Makefile.am</code>
<li>
add it to the
AC_CONFIG_FILES directive in <code>configure.ac</code>.
</ul>

<h2>Version number</h2>
To set the BOINC client version:
<pre>
  set-version 7.17.56
</pre>
in the BOINC top-level source directory.  This updates
the <code>AC_INIT</code> line in
<code>configure.ac</code> and regenerates files that use the version numbers
(config.h, py/version.py, test/version.inc, client/win/win_config.h, Makefiles)

";
page_tail();
?>
