# okra-wp-plugin

Welcome to the Okra wordpress plugin repository on GitHub. Here you can browse the source, look at open issues and keep track of development. 

## Installation

1. Install the [Okra wordpress plugin](https://wordpress.org/plugins/okra/) via the Plugins section of your WordPress Dashboard or 
   pull down the repo and zip the `okra-dev-wp` folder.
   
2. Go to `Plugins > Add New` and search for the okra plugin, if you have pulled and zipped the repo click on the `upload button` at the top of the page, select the zipped repo and click `install now`.

3. The menu `Okra` would appear on the side menu, with the menus **All Forms**, **Settings**, **Styles**, **Payment Integration**.

  - **All Forms** <br />
This allows you to create various instances of an element that when clicked, would call the okra widget.
 
 ![All forms page](https://i.imgur.com/mtVUZ89.png)
   
  - **Settings**
 ![All forms page](https://i.imgur.com/0wcOiew.png)
      
|Name                   | Type           | Required            | Default Value       | Description         |
|-----------------------|----------------|---------------------|---------------------|---------------------|
|  `key `               | `String`       | true                |  undefined          | Your public key from Okra.
|  `token`              | `String`       | true                |  undefined          | Your pubic Key from okra. Use test key for test mode and live key for live mode
|  `env`                | `Enums.Environment`| true            |  undefined          | 
|  `clientName`         | `String`       | true                |  undefined          | Name of the customer using the widget on the application    

  - **Styles** <br />
  This is used to style the okra widget to your taste:
  ![style page](https://i.imgur.com/J0l7QXA.png)
  
  
  - **Payment Integration**

4. Add the form element created in `All forms` as an element in the wordpress page created.
  ![style page](https://i.imgur.com/B2FJh6a.gif)


## Documentation
* [https://docs.okra.ng/](https://docs.okra.ng/)
