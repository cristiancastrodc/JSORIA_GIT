{!!Html::script('vendors/bootgrid/jquery.bootgrid.updated.min.js')!!}
{!!Html::script('js/own.scripts.js')!!}
<script type="text/javascript">
    $(document).ready(function(){
        $("#pagos-pendientes").bootgrid({
            css: {
                icon: 'zmdi icon',
                iconColumns: 'zmdi-view-module',
                iconDown: 'zmdi-expand-more',
                iconRefresh: 'zmdi-refresh',
                iconUp: 'zmdi-expand-less'
            },
            selection : true,
            multiSelect : true,
            rowSelect : true,
            keepSelection : true,
            navigation : 0,
        });
      });
</script>