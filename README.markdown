About
-----

Squiz Viper is a true inline WYSIWYG editor that can also be used in-context to provide a truly integrated editing experience. Inline editing tools are provided to help content authors reach common editing tools based on their current selection. An integrated WCAG2 accessibility auditor based on [HTML_CodeSniffer](http://http://squizlabs.github.com/HTML_CodeSniffer) provides inline accesibility checking with resolution interfaces for common mistakes.

Resolution Interfaces
---------------------

The following resolution interfaces are provided by Squiz Viper:

### [Standard].Principle1.Guideline1_1.1_1_1.H30.2
**Error:** Img element is the only content of the link, but is missing alt text. The alt text should describe the purpose of the link.  
**Solution:** Make sure the image's alt text describes the purpose of the link it's being used for.

### [Standard].Principle1.Guideline1_1.1_1_1.H37
**Error:** Img element missing an alt attribute. Use the alt attribute to specify a short text alternative.  
**Solution:** Enter a short text description of the image, or define the image as purely decorative.  
**Example:** 
```html
<img src="" />
```

### [Standard].Principle1.Guideline1_1.1_1_1.H67.1
**Error:** Img element with empty alt text must have absent or empty title attribute.  
**Solution:** Ensure this image is purely decorative. If not, enter appropriate alt and title text.  
**Example:**
```html
<img src="" alt="" title="Link title text" />
```

### [Standard].Principle1.Guideline1_1.1_1_1.H67.2
**Warning:** Img element is marked so that it is ignored by Assistive Technology.  
**Solution:** Ensure this image is purely decorative. If not, enter appropriate alt and title text.  
**Example:**
```html
<img src="" alt="" />
```

### [Standard].Principle1.Guideline1_1.1_1_1.G94.Image
**Notice:** Ensure that the img element's alt text serves the same purpose and presents the same information as the image.  
**Solution:** Ensure the image's alt text describes the purpose or content of the image.  
**Example:**
```html
<img src="" alt="Link alt text" />
```

### [Standard].Principle1.Guideline1_1.1_1_1.H2.EG3
**Error:** Img element inside a link must not use alt text that duplicates the content of a text link beside it.  
**Solution:** Update the image's alt text to something other than the nearby link "[Link text]".

### [Standard].Principle1.Guideline1_3.1_3_1.H39,H73.4
**Error:** If both a summary attribute and a caption element are present for this data table, the summary should not duplicate the caption  
**Solution:** Update either the table's caption or summary so they are not identical.

### [Standard].Principle1.Guideline1_3.1_3_1.H48.1
**Warning:** Content appears to have the visual appearance of a bulleted list. It may be appropriate to mark this content up using a ul element.  
**Solution:** This section of content resembles a content list. If this is intentional, it should be converted to the proper list format.

### [Standard].Principle1.Guideline1_3.1_3_1.H48.2
**Warning:** Content appears to have the visual appearance of a numbered list. It may be appropriate to mark this content up using an ol element.  
**Solution:** This section of content resembles a numbered list. If this is intentional it should be converted to the proper list format.

### [Standard].Principle1.Guideline1_3.1_3_1.H49.b
**Error:** Semantic markup should be used to mark emphasised or special text so that it can be programmatically determined.  
**Solution:** Convert the B tag to the more appropriate STRONG tag.  
**Example:**
```html
<b>My text</b>
```

### [Standard].Principle1.Guideline1_3.1_3_1.H49.i
**Error:** Semantic markup should be used to mark emphasised or special text so that it can be programmatically determined.  
**Solution:** Convert the I tag to the more appropriate EM tag.  
**Example:**
```html
<i>My text</i>
```

### [Standard].Principle1.Guideline1_3.1_3_1.H49.u
**Error:** Semantic markup should be used to mark emphasised or special text so that it can be programmatically determined.  
**Solution:** The U tag should be removed to reduce confusion with links.  
**Example:**
```html
<u>My text</u>
```

### [Standard].Principle1.Guideline1_3.1_3_1.H49.s
**Error:** Semantic markup should be used to mark emphasised or special text so that it can be programmatically determined.  
**Solution:** The S tag needs to be replaced with a DEL tag.  
**Example:**
```html
<s>My text</s>
```

### [Standard].Principle1.Guideline1_3.1_3_1.H49.strike
**Error:** Semantic markup should be used to mark emphasised or special text so that it can be programmatically determined.  
**Solution:** The Strike tag needs to be replaced with a DEL tag.  
**Example:**
```html
<strike>My text</strike>
```

### [Standard].Principle1.Guideline1_3.1_3_1.H49.tt
**Error:** Semantic markup should be used to mark emphasised or special text so that it can be programmatically determined.  
**Solution:** The TT tag needs to be replaced with a CODE tag.  
**Example:**
```html
<tt>My text</tt>
```

### [Standard].Principle1.Guideline1_3.1_3_1.H49.big
**Error:** Semantic markup should be used to mark emphasised or special text so that it can be programmatically determined.  
**Solution:** The BIG tag needs to be removed.  
**Example:**
```html
<big>My text</big>
```

### [Standard].Principle1.Guideline1_3.1_3_1.H49.small
**Error:** Semantic markup should be used to mark emphasised or special text so that it can be programmatically determined.  
**Solution:** The SMALL tag needs to be removed.  
**Example:**
```html
<small>My text</small>
```

### [Standard].Principle1.Guideline1_3.1_3_1.H49.center
**Error:** Semantic markup should be used to mark emphasised or special text so that it can be programmatically determined.  
**Solution:** The CENTER tag needs to be converted to a CSS based alignment method.  
**Example:**
```html
<center>My text</center>
```

### [Standard].Principle1.Guideline1_3.1_3_1.H49.font
**Error:** Semantic markup should be used to mark emphasised or special text so that it can be programmatically determined.  
**Solution:** The FONT tag needs to be removed. Consider using a CSS class on the containing element to achieve variations in fonts/colours/sizes etc.  
**Example:**
```html
<font size="2">My text</font>
```

### [Standard].Principle1.Guideline1_3.1_3_1.H49.AlignAttr
**Error:** Semantic markup should be used to mark emphasised or special text so that it can be programmatically determined.  
**Solution:** The ALIGN attribute needs to be converted to a CSS based alignment method.  
**Example:**
```html
<p align="right">My text</p>
```

### [Standard].Principle1.Guideline1_3.1_3_1.H42
**Warning:** Heading markup should be used if this content is intended as a heading.  
**Solution:** If a paragraph's content consists solely of bold or italic text to simulate a heading it should be converted to the appropriate heading level.

### [Standard].Principle1.Guideline1_3.1_3_1.H73.3.NoSummary
**Warning:** Consider using the summary attribute of the table element to give an overview of this data table.  
**Solution:** Enter a summary for the table.

### [Standard].Principle1.Guideline1_3.1_3_1.H73.3.Check
**Notice:** Check that the summary attribute describes the table's organization or explains how to use the table.  
**Solution:** Enter a summary for the table.

### [Standard].Principle1.Guideline1_3.1_3_1.H39.3.NoCaption
**Warning:** Consider using a caption element to the table element to identify this data table.  
**Solution:** Enter a caption for the table.

### [Standard].Principle1.Guideline1_3.1_3_1.H39.3.Check
**Notice:** Check that the caption element accurately describes this table.  
**Solution:** Enter a caption for the table.

### [Standard].Principle2.Guideline2_4.2_4_1.H64.1
**Error:** Iframe element requires a non-empty title attribute that identifies the frame.  
**Solution:** Enter an appropriate title for the iframe to describe it's purpose.  
**Example:**
```html
<iframe src="" />
```

### [Standard].Principle2.Guideline2_4.2_4_1.H64.2
**Notice:** Check that the title attribute of this element contains text that identifies the frame.  
**Solution:** Enter an appropriate title for the iframe to describe it's purpose.  
**Example:**
```html
<iframe src="" title="Frame title text" />
```

### [Standard].Principle4.Guideline4_1.4_1_1.F77
**Error:** Duplicate id attribute value "[Element ID]" found on the web page.  
**Solution:** Update the ID to be unique.  
**Example:**
```html
<p id="myid">Para 1</p><p id="myid">Para 2</p>
```

Resolution Interfaces TODO
--------------------------

The following resolution interfaces are still be completed:

### [Standard].Principle1.Guideline1_3.1_3_1.H43.HeadersRequired
**Error:** Associate data cells with multi-level table headings using the headers attribute.

### [Standard].Principle1.Guideline1_3.1_3_1.H43,H63
**Error:** Associate data cells with table headings using either the scope or headers attribute techniques.

### [Standard].Principle1.Guideline1_3.1_3_1.H43.IncorrectAttr
**Error:** Incorrect headers attribute, expected [expected headers] but found [actual headers]

### [Standard].Principle1.Guideline1_3.1_3_1.H43.MissingHeadersAttrs
**Error:** Not all td elements contain a headers attribute, which list the ids of all headers associated with that cell.

### [Standard].Principle1.Guideline1_3.1_3_1.H43.MissingHeaderIds
**Error:** Not all th elements in this table contain an id attribute, so that they may be referenced by td elements' headers attributes.
