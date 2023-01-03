const charts = document.querySelectorAll(".chart");

charts.forEach(function (chart) {
  var ctx = chart.getContext("2d");
  var myChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
      datasets: [
        {
          label: "# of Votes",
          data: [12, 19, 3, 5, 2, 3],
          backgroundColor: [
            "rgba(255, 99, 132, 0.2)",
            "rgba(54, 162, 235, 0.2)",
            "rgba(255, 206, 86, 0.2)",
            "rgba(75, 192, 192, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
          ],
          borderColor: [
            "rgba(255, 99, 132, 1)",
            "rgba(54, 162, 235, 1)",
            "rgba(255, 206, 86, 1)",
            "rgba(75, 192, 192, 1)",
            "rgba(153, 102, 255, 1)",
            "rgba(255, 159, 64, 1)",
          ],
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
});

$(document).ready(function () {
  $(".data-table").each(function (_, table) {
    $(table).DataTable();
  });
});

async function visualizarAssociado(id) {
  //console.log ("Acessou: " + id);
  const dados = await fetch('visualizarAssociado.php?id=' + id);
  const resposta = await dados.json();
  console.log(resposta);

  if (resposta['erro']) {
    msgAlerta.innerHTML = resposta['msg'];
  } else {
    const visModal = new bootstrap.Modal(document.getElementById("perfilAssociado"));
    visModal.show();

    document.getElementById("nomeAssociado").innerHTML = resposta['dados'].nome;
    document.getElementById("idAssociado").innerHTML = resposta['dados'].id;
    document.getElementById("cpfAssociado").innerHTML = resposta['dados'].cpf;
    document.getElementById("nacionalidadeAssociado").innerHTML = resposta['dados'].nacionalidade;
    document.getElementById("generoAssociado").innerHTML = resposta['dados'].genero;
    document.getElementById("estadoCivilAssociado").innerHTML = resposta['dados'].estado_civil;
    document.getElementById("dataNascimentolidadeAssociado").innerHTML = resposta['dados'].data_nascimento;
    document.getElementById("emailAssociado").innerHTML = resposta['dados'].email;
    document.getElementById("profissaoAssociado").innerHTML = resposta['dados'].profissao;
    document.getElementById("telefoneAssociado").innerHTML = resposta['dados'].telefone;
    document.getElementById("enderecoAssociado").innerHTML = resposta['dados'].endereco;
    document.getElementById("cidadeAssociado").innerHTML = resposta['dados'].cidade;
    document.getElementById("estadoAssociado").innerHTML = resposta['dados'].estado;
    document.getElementById("planoAssociado").innerHTML = resposta['dados'].plano;
    document.getElementById("dataAquisicaoAssociado").innerHTML = resposta['dados'].data_aquisicao;
    document.getElementById("datavencimentoAssociado").innerHTML = resposta['dados'].data_vencimento;
  }
}

async function editarAssociado(id) {
  const dados = await fetch('editarAssociado.php?id=' + id);
  const resposta = await dados.json();
  console.log(resposta);

  if (resposta['erro']) {
    msgAlerta.innerHTML = resposta['msg'];
  } else {
    const editModal = new bootstrap.Modal(document.getElementById("editarAssociados"));
    editModal.show();

    document.getElementById("nome").value = resposta['dados'].nome;
    //validação de radius e checkbox
    switch(resposta['dados'].estado_civil){
      case "solteiro":
        const checkboxsolt = document.querySelector("#solteiro");
      function ativarCheckbox(el) {
        el.checked = true;
      }
      ativarCheckbox(checkboxsolt);
      break;
      case "casado":
        const checkboxcas = document.querySelector("#casado");
      function ativarCheckbox(el) {
        el.checked = true;
      }
      ativarCheckbox(checkboxcas);
      break;
      case "divorciado":
        const checkboxdiv = document.querySelector("#divorciado");
      function ativarCheckbox(el) {
        el.checked = true;
      }
      ativarCheckbox(checkboxdiv);
      break;
      case "viuvo":
        const checkboxviu = document.querySelector("#viuvo");
      function ativarCheckbox(el) {
        el.checked = true;
      }
      ativarCheckbox(checkboxviu);
      break;
      case "":
        break;
    }

    document.getElementById("nacionalidade").value = resposta['dados'].nacionalidade;
    document.getElementById("profissao").value = resposta['dados'].profissao;
    document.getElementById("cpf").value = resposta['dados'].cpf;
    document.getElementById("email").value = resposta['dados'].email;
    document.getElementById("telefone").value = resposta['dados'].telefone;
    
    switch(resposta['dados'].genero){
      case "masculino":
        const checkboxmas = document.querySelector("#masculino");
      function ativarCheckbox(el) {
        el.checked = true;
      }
      ativarCheckbox(checkboxmas);
      break;
      case "feminino":
        const checkboxfem = document.querySelector("#feminino");
      function ativarCheckbox(el) {
        el.checked = true;
      }
      ativarCheckbox(checkboxfem);
      break;
      case "outro":
        const checkboxout = document.querySelector("#outro");
      function ativarCheckbox(el) {
        el.checked = true;
      }
      ativarCheckbox(checkboxout);
      break;
    }

    document.getElementById("data_nascimento").value = resposta['dados'].data_nascimento;
    document.getElementById("cidade").value = resposta['dados'].cidade;
    document.getElementById("estado").value = resposta['dados'].estado;
    document.getElementById("endereco").value = resposta['dados'].endereco;

    switch(resposta['dados'].plano){
      case "mensal":
        const checkboxmen = document.querySelector("#mensal");
      function ativarCheckbox(el) {
        el.checked = true;
      }
      ativarCheckbox(checkboxmen);
      break;
      case "anual":
        const checkboxanual = document.querySelector("#anual");
      function ativarCheckbox(el) {
        el.checked = true;
      }
      ativarCheckbox(checkboxanual);
      break;
    }

    document.getElementById("data_aquisicao").value = resposta['dados'].data_aquisicao;
    document.getElementById("id").value = resposta['dados'].id;
  }
}

async function deleteAssociado(id) {
  const dados = await fetch('deleteAssociado.php?id=' + id);
  const resposta = await dados.json();
  console.log(resposta);

  if (resposta['erro']) {
    msgAlerta.innerHTML = resposta['msg'];
  } else {
    const delModal = new bootstrap.Modal(document.getElementById("removerAssociado"));
    delModal.show();

    document.getElementById("idAssociadoDel").innerHTML = resposta['dados'].id;
    document.getElementById("nomeAssociadoDel").innerHTML = resposta['dados'].nome;
  }
}

