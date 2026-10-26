$(document).ready(function() {
        var table = $('#scroll-horizontal-datatable').DataTable();

        $('#yearFilter, #quarterFilter').on('change', function() {
        var year = $('#yearFilter').val();
        var quarter = $('#quarterFilter').val();
        
        // Logika filter
        table.column(3).search(year).draw(); // Misalnya kolom 0 adalah tahun
        table.column(4).search(quarter).draw(); // Misalnya kolom 1 adalah kuartal
});
    });

    $(document).ready(function() {
        var table = $('#basic-datatable').DataTable();

        $('#yearFilter, #quarterFilter').on('change', function() {
        var year = $('#yearFilter').val();
        var quarter = $('#quarterFilter').val();
        
        // Logika filter
        table.column(3).search(year).draw(); // Misalnya kolom 0 adalah tahun
        table.column(4).search(quarter).draw(); // Misalnya kolom 1 adalah kuartal
});
    });

    $(document).ready(function() {
        var table = $('#row-callback-datatable').DataTable();

        $('#yearFilter, #quarterFilter').on('change', function() {
        var year = $('#yearFilter').val();
        var quarter = $('#quarterFilter').val();
        
        // Logika filter
        table.column(3).search(year).draw(); // Misalnya kolom 0 adalah tahun
        table.column(4).search(quarter).draw(); // Misalnya kolom 1 adalah kuartal
});
    });

    $(document).ready(function() {
        var table = $('#selection-datatable').DataTable();

        $('#yearFilter, #quarterFilter').on('change', function() {
        var year = $('#yearFilter').val();
        var quarter = $('#quarterFilter').val();
        
        // Logika filter
        table.column(3).search(year).draw(); // Misalnya kolom 0 adalah tahun
        table.column(4).search(quarter).draw(); // Misalnya kolom 1 adalah kuartal
});
    });