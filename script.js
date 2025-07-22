const products = [
  {
    name: "Semen Tiga Roda",
    price: 60000,
    description: "Semen berkualitas tinggi untuk konstruksi",
    image: "semen.jpg",
    category: "semen"
  },
  {
    name: "Cat Dulux Warna Merah",
    price: 85000,
    description: "Cat tembok interior dan eksterior",
    image: "cat.jpg",
    category: "cat"
  },
  {
    name: "Paku 5cm",
    price: 15000,
    description: "Paku baja untuk kebutuhan konstruksi",
    image: "paku.jpg",
    category: "paku"
  },
  {
    name: "Cat Avian Putih",
    price: 75000,
    description: "Cat dinding tahan lama",
    image: "aviat.jpg",
    category: "cat"
  },
  {
    name: "Semen Gresik",
    price: 58000,
    description: "Semen serbaguna dan kuat",
    image: "grseik.jpg",
    category: "semen"
  }
];

const productList = document.getElementById("product-list");
const categoryFilter = document.getElementById("categoryFilter");

function displayProducts(filteredProducts) {
  productList.innerHTML = "";

  filteredProducts.forEach(product => {
    const card = document.createElement("div");
    card.className = "product-card";
    card.innerHTML = `
      <img src="${product.image}" alt="${product.name}" />
      <h3>${product.name}</h3>
      <p><strong>Rp${product.price.toLocaleString()}</strong></p>
      <p>${product.description}</p>
    `;
    productList.appendChild(card);
  });
}

function filterProducts() {
  const category = categoryFilter.value;
  if (category === "all") {
    displayProducts(products);
  } else {
    const filtered = products.filter(p => p.category === category);
    displayProducts(filtered);
  }
}

categoryFilter.addEventListener("change", filterProducts);

// Tampilkan semua produk saat pertama kali halaman dimuat
displayProducts(products);
