#!/bin/bash
####################################################
# @file:   build.sh
# @author: mawentao
# @create: 2016-02-15 15:49:32
# @modify: 2016-02-15 15:49:32
# @brief:  build.sh
####################################################

pluginname="wxconnect"
outdir="output/$pluginname"
tarname="$pluginname.zip"
src="src-"`date +%s`

function cpfiles()
{
    for i in $@; do
        cp -r $i $outdir
    done
}

################################
rm -rf output
mkdir -p $outdir
################################
cpfiles api *.php *.xml class table template model
################################
#mv $outdir/fe/src $outdir/fe/$src
#sed -i "s/src\//$src\//g" $outdir/fe/login.html
sed -i "s/mwt3.2utf8 (http:\/\/10.3.70.15:8008\/discuz\/)/dz3.2utf8 (http:\/\/192.168.0.1\/dz)/g" $outdir/discuz_plugin_wxconnect.xml
sed -i "s/X3.2/X2.5,X3,X3.1,X3.2/g" $outdir/discuz_plugin_wxconnect.xml
################################
cd $outdir
rm template/libs/mwt/update.sh
rm -rf data
# 删除php文件中的所有注释代码
../../clear_annotation -r -w
iconv -f UTF-8 -t GBK discuz_plugin_wxconnect.xml > discuz_plugin_wxconnect_SC_GBK.xml
mv discuz_plugin_wxconnect.xml discuz_plugin_wxconnect_SC_UTF8.xml
find . -type d -name ".svn" | xargs rm -rf
find . -name "*.bk" | xargs rm -rf
cd ../; zip -r $tarname $pluginname
cd ../
################################

echo 'build success'
exit 0
