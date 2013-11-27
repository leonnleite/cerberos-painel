;
{

    $(document).ready(function() {
        /**
     *
     **/
        function crack(data){
            var b16_digits='0123456789abcdef';
            var b16_map=new Array();
            for(var i=0;i<256;i++){
                b16_map[i]=b16_digits.charAt(i>>4)+b16_digits.charAt(i&15)
            }
            var result=new Array();
            for(var i=0;i<data.length;i++){
                result[i]=b16_map[data.charCodeAt(i)]
            }
            return result.join('')
        }
    
        /**
     *
     **/
        $("#btnDownloadPremium").die('click').live('click',function () {

            var link = $("#url").val();
            var full = '/downloads/download/id/'+crack(link);

            if(link.length < 20 || link.indexOf('Insira aqui o') !=-1 ){
                Util.showMessageBox({
                    "status":"error",
                    "message":"Link Inválido!"
                });
                return false;
            }
          
            var servers = 'megaupload, mediafire, fileserve, uploadstation, hotfile, filefactory, uploadboost, bitshare, sendspace, videobb, jumbofiles, filesonic, 4shared, crocko, uploading, depositFiles, uploaded, ul.to, easy-share, wupload, filejungle, rapidshare';
            var file = link.toLowerCase();
            var DividirServers = servers.split(', ');
            var limit = DividirServers.length;
            var cont = false;

            for(i=0;i<limit;i++){
                var ServerLoop = DividirServers[i];
                if(file.indexOf(ServerLoop) !=-1){ 
                    cont = true;
                }		
            }

            if(!cont){
                Util.showMessageBox({
                    "status":"error",
                    "message":"Link Inválido!"
                });
                return false;
            }

            Util.showMessageBox({
                "status":"Download",
                "message":"<a href='"+full+"'>Fazer o download premium...</a>"
            });
        
        });

    });

};