@page {
  margin: {{ $mt }}px 50px 50px 50px;
}
html {
  font-family: sans-serif;
  font-size: 10px;
}
.header {
  position: fixed;
  left: 0;
  top: -{{ $mt }}px;
  right: 0;
  text-align: center;
}
.footer {
  position: fixed;
  left: 0;
  bottom: -15px;
  right: 0;
  text-align: center;
}
.footer .pagenum:before {
  content: counter(page);
}
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  margin-bottom: 0;
}
table > thead > tr {
  background-color: #e6e6ff;
}
table.bordered td {
  border-bottom: 1px solid #000;
}
table td {
  padding: 5px;
}
/* Alignments */
.text-right {
  text-align: right;
}
.text-left {
  text-align: left;
}
.text-center {
  text-align: center;
}
/* Contextual classes */
.bg-success {
  background-color: #DFF0D8;
}
.bg-danger {
  background-color: #F2DEDE;
}
