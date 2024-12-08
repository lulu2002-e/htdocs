<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University of Bahrain Student Nationality Data</title>
    <!-- Pico CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Student Nationality and Enrollment Data</h1>
        <table id="studentTable">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Semester</th>
                    <th>College</th>
                    <th>Program</th>
                    <th>Nationality</th>
                    <th>Number of Students</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Data will be dynamically inserted here -->
            </tbody>
        </table>
    </div>

    <script>
        // JavaScript code 
        const URL = "https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100";

        async function fetchStudentData() {
            try {
                const proxyUrl = "https://corsproxy.io/?" + encodeURIComponent(URL);

                const response = await fetch(proxyUrl, {
                    method: "GET",
                    headers: { Accept: "application/json" },
                });

                if (!response.ok) {
                    throw new Error(HTTP error! status: ${response.status});
                }

                const data = await response.json();
                const tableBody = document.getElementById("tableBody");
                tableBody.innerHTML = "";

                if (data.results && data.results.length > 0) {
                    data.results.forEach((record) => {
                        const row = document.createElement("tr");
                        const cells = [
                            record.year ?? "N/A",
                            record.semester ?? "N/A",
                            record.colleges ?? "N/A",
                            record.the_programs ?? "N/A",
                            record.nationality ?? "N/A",
                            record.number_of_students ?? "N/A",
                        ];

                        cells.forEach((cellData) => {
                            const cell = document.createElement("td");
                            cell.textContent = cellData;
                            row.appendChild(cell);
                        });

                        tableBody.appendChild(row);
                    });
                } else {
                    const noDataRow = document.createElement("tr");
                    const noDataCell = document.createElement("td");
                    noDataCell.colSpan = 6;
                    noDataCell.textContent = "No data found";
                    noDataRow.appendChild(noDataCell);
                    tableBody.appendChild(noDataRow);
                }
            } catch (error) {
                console.error("Error fetching student data:", error);

                const tableBody = document.getElementById("tableBody");
                const errorRow = document.createElement("tr");
                const errorCell = document.createElement("td");
                errorCell.colSpan = 6;
                errorCell.textContent = Error: ${error.message};
                errorCell.style.color = "red";
                errorRow.appendChild(errorCell);
                tableBody.appendChild(errorRow);
            }
        }

        document.addEventListener("DOMContentLoaded", fetchStudentData);
    </script>
</body>
</html>
