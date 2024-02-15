<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/materialize.css">
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <title>Table Viewer</title>
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="/" class="brand-logo center">Table Viewer</a>
        </div>
    </nav>
    <div class="container">
        <div class="column">
            <div class="row">
                <form id="fetchForm" method="GET" action="/api/paginate">
                    <div class="input-field col s3 offset-s4">
                        <input id="search" type="text">
                        <label for="search">Enter an id to search for in the database</label>
                    </div>
                    <div class="col s2">
                        <button class="btn waves-effect waves-light" type="submit" name="action" id="submitButton">
                            load
                            <i class="material-icons right">search</i>
                        </button>
                    </div>

                </form>
            </div>

            <div class="row">
                <div class="column s12">
                    <div class="row s11">
                        <table class="highlight centered">
                            <thead>
                            <tr>
                                <th>Ad ID</th>
                                <th>Impressions</th>
                                <th>Clicks</th>
                                <th>Unique Clicks</th>
                                <th>Leads</th>
                                <th>Conversion</th>
                                <th>ROI (%)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row s1">
                        <ul class="pagination center" id="pages">
                            <li class="disabled"><a href="/"><i class="material-icons">chevron_left</i></a></li>
                            <li class="active"><a href="/">1</a></li>
                            <li class="waves-effect"><a href="/">2</a></li>
                            <li class="waves-effect"><a href="/">3</a></li>
                            <li class="waves-effect"><a href="/">4</a></li>
                            <li class="waves-effect"><a href="/">5</a></li>
                            <li class="waves-effect"><a href="/"><i class="material-icons">chevron_right</i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/materialize.js">M.AutoInit();</script>
    <script src="js/app.js"></script>
    <script type="application/javascript">
        const defaultRequest = '/api/ads/paginate';
        const fetchForm = document.getElementById("fetchForm");

        window.addEventListener("load", () => {
            reloadTable(defaultRequest);
        });
        fetchForm.addEventListener("submit", (e) => {
            e.preventDefault()
            let search = document.getElementById("search").value;
            reloadTable(defaultRequest + '?search=' + search);

        });

        async function reloadTable(requestURL) {
            const tbody = document.getElementsByTagName('tbody')[0];
            tbody.innerHTML = ``;
            const rawData = await fetch(requestURL);
            const data = await rawData.json();

            // console.log(data);

            data.data.forEach(item => {
                let row = tbody.insertRow();
                Object.values(item).forEach(value => {
                    let cell = row.insertCell();
                    cell.textContent = value;
                });
            });
            const paginator = document.getElementById('pages');
            paginator.innerHTML = '';


            data.links.forEach(item => {
                const li = document.createElement('li');
                const a = document.createElement('a');

                if (item.url) {
                    li.setAttribute('onclick', `reloadTable('${item.url}')`);
                    li.classList.add('waves-effect');
                } else {
                    li.classList.add('disabled');
                }

                if (item.active) {
                    li.classList.add('active');
                }

                if (item.label === '&laquo; Previous') {
                    a.innerHTML = '<i class="material-icons">chevron_left</i>';
                } else if (item.label === 'Next &raquo;') {
                    a.innerHTML = '<i class="material-icons">chevron_right</i>';
                } else {
                    a.innerHTML = item.label;
                }

                li.appendChild(a);
                paginator.appendChild(li);
            });

        }
    </script>
    </body>
</html>


