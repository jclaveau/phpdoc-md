
# \PHPDocMD \ MyClass


<!-- Mardown tables do not handle tables without column names -->
<table>
    <tbody>
        <tr>
            <th>Namespace</th>
            <td>\PHPDocMD</td>
        </tr>
                                <tr>
                <th>Extends</th>
                <td><a href='PHPDocMD-MyParentClass.md' >\PHPDocMD\MyParentClass</a>,<br><a href='PHPDocMD-MyGrandParentClass.md' >\PHPDocMD\MyGrandParentClass</a></td>
            </tr>
                            <tr>
                <th>Implements</th>
                <td><a href='PHPDocMD-MyInterface.md' >\PHPDocMD\MyInterface</a>,<br><a href='PHPDocMD-MySecondInterface.md' >\PHPDocMD\MySecondInterface</a></td>
            </tr>
            </tbody>
</table>

## Constants
#### - <a href='../../mockups/MyClass.php#L8'> const MyClass::constant_without_description = 'not descripted'</a>
#### - <a href='../../mockups/MyClass.php#L13'> const MyClass::constant_with_description = 'I MUST have a description'</a>
<blockquote><pre>The description of my constant</pre></blockquote>



## Properties
#### - <a href='../../mockups/MyClass.php#L18'>protected string MyClass->protectedProperty</a>
<blockquote><pre>A protected property of MyClass</pre></blockquote>


#### - <a href='../../mockups/MyClass.php#L19'>private  MyClass->privateProperty</a>
#### - <a href='../../mockups/MyClass.php#L20'>public  MyClass->publicProperty</a>
#### - <a href='../../mockups/MyClass.php#L10'>protected string MyClass->protectedPropertyOfMyTrait</a>
<blockquote><pre>A protected property of MyTrait</pre></blockquote>


#### - <a href='../../mockups/MyClass.php#L10'>protected string MyClass->protectedPropertyOfMyTrait2</a>
<blockquote><pre>Second protected property of MyTrait</pre></blockquote>


#### - <a href='../../mockups/MyClass.php#L6'>protected  MyClass::$myStaticProperty</a>

## Methods
#### - <a href='../../mockups/MyClass.php#L27'>public MyClass::getProtectedProperty() : string</a>
<blockquote><pre>Getter of protectedProperty.<br><br>Returns a <a href='https://www.php.net/manual/en/language.types.string.php' target='_blank'>string</a>: The value of $this->protectedProperty</pre></blockquote>


#### - <a href='../../mockups/MyClass.php#L38'>public MyClass::setProtectedProperty() : MyClass</a>
<blockquote><pre>Setter of protectedProperty.<br><br>Parameters:<br> &#x25FE; <a href='https://www.php.net/manual/en/language.types.string.php' target='_blank'>string</a> $value: The value to assign to $this->protectedProperty<br> &#x25FE; <a href='https://www.php.net/manual/en/language.types.array.php' target='_blank'>array</a> $options<br><br>Returns a <a href='PHPDocMD-MyClass.md' >\PHPDocMD\MyClass</a>: The current instance of MyClass</pre></blockquote>


#### - <a href='../../mockups/MyClass.php#L49'>protected MyClass::protectedMethod()</a>
#### - <a href='../../mockups/MyClass.php#L12'>public MyClass::getterOfMyTrait()</a>
#### - <a href='../../mockups/MyClass.php#L17'>public MyClass::setterOfMyTrait()</a>
<blockquote><pre>Parameters:<br> &#x25FE; <a href='https://www.php.net/manual/en/language.types.array.php' target='_blank'>array</a> $value</pre></blockquote>



### Defined by: <a href='PHPDocMD-MyParentClass.md' >\PHPDocMD\MyParentClass</a>
#### - <a href='../../mockups/MyParentClass.php#L6'>final public static MyParentClass::setStaticProperty()</a>
<blockquote><pre>Parameters:<br> &#x25FE; mixed $value</pre></blockquote>



### Defined by: <a href='PHPDocMD-MyGrandParentClass.md' >\PHPDocMD\MyGrandParentClass</a>
#### - <a href='../../mockups/MyGrandParentClass.php#L8'>public static MyGrandParentClass::getStaticProperty()</a>

### Defined by: <a href='PHPDocMD-MyInterface.md' >\PHPDocMD\MyInterface</a>
#### - <a href='../../mockups/MyInterface.php#L6'>public MyInterface::methodOfMyInterface()</a>

### Defined by: <a href='PHPDocMD-MySecondInterface.md' >\PHPDocMD\MySecondInterface</a>
#### - <a href='../../mockups/MySecondInterface.php#L6'>public MySecondInterface::methodOfMySecondInterface()</a>
